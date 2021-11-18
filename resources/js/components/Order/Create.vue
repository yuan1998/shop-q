<template>
    <div class="order-create">
        <van-nav-bar fixed placeholder left-arrow title="创建订单" @click-left="$router.back()">
            <template #title>
                <div class="nav_title">
                    <van-image
                        width="30px"
                        height="30px"
                        fit="cover"
                        round
                        src="https://api.qicaiyun.top/sjtx/api.php?lx=c1"
                        style="margin-right:10px;"
                    />
                    {{ hour }}小时前给出五星好评
                </div>
            </template>

        </van-nav-bar>
        <div class="order-create_location">
            <van-cell v-if="chosenLocation"
                      icon="location"
                      :border="false"
                      is-link
                      value-class="van-concat-card__value"
                      class="van-cell--center van-cell--clickable van-cell--borderless van-contact-card van-location-card--add"
                      @click="handleLocation"
            >
                <template #title>
                    <div class="location_title"><strong>{{ chosenLocation.name }}</strong> {{ chosenLocation.phone }}
                    </div>
                </template>
                <template #label>
                    <div class="location_label">
                        {{ chosenLocation.detail }}
                    </div>
                </template>
            </van-cell>
            <van-cell v-else
                      icon="add-square"
                      :border="false"
                      value="添加收货地址"
                      is-link
                      value-class="van-contact-card__value"
                      class="van-cell--center van-cell--clickable van-cell--borderless van-contact-card van-contact-card--add"
                      @click="handleLocation"
            />

        </div>

        <div>
            <div class="order-title">
                订单商品
            </div>
            <van-card class="card-product"

                      :thumb="`/storage/${query.image}`"
            >
                <template #price>
                    <div>
                        <span class="van-card__price-currency">¥</span>
                        <span class="van-card__price-integer">{{ query.price }}</span>
                    </div>
                </template>
                <template #title>
                    <div class="card-product_title">
                        {{ query.title }}
                    </div>
                </template>
                <template #desc>
                    <div class="card-product_sku">
                        {{ query.sku }}
                    </div>
                    <div class="card-product_text">
                        最晚48小时发货
                    </div>
                    <div class="card-product_text red">
                        库存紧张
                    </div>
                    <div class="card-product_text tags">
                    <span>
                        正品保障
                    </span>
                        <span>
                        7天无理由
                    </span>
                    </div>
                </template>
                <template #num>
                    <van-stepper v-model="count"/>
                </template>
            </van-card>
            <van-cell>
                <template #title>
                    <div class="card-product_info_title">
                        订单运费
                    </div>
                </template>
                <template #value>
                    <div class="card-product_info_value">
                        包邮
                    </div>
                </template>
            </van-cell>
            <van-cell>
                <template #title>
                    <div class="card-product_info_title">
                        运费险
                        <van-icon name="question-o"/>
                    </div>
                </template>
                <template #value>
                    <div class="card-product_info_value">
                        商家赠送
                    </div>
                </template>
            </van-cell>
            <van-field placeholder="选填, 建议先与商家协商一致">
                <template #label>
                    <div class="card-product_info_title">
                        订单留言
                    </div>
                </template>
            </van-field>
        </div>

        <div class="payment">

            <van-radio-group v-model="payment">
                <van-cell-group>
                    <van-cell clickable @click="payment = 'wechat'">
                        <template #title>
                            <div style="display:flex;align-items: center;">
                                <van-image width="30"
                                           height="30"
                                           src="https://pic.imgdb.cn/item/618a48d52ab3f51d917adac2.png"
                                           round/>
                                <div style="margin-left: 15px;">微信支付</div>
                            </div>
                        </template>
                        <template #right-icon>
                            <van-radio name="wechat" checked-color="#F93E5B"/>
                        </template>
                    </van-cell>
                    <van-cell clickable @click="payment = 'alipay'">
                        <template #title>
                            <div style="display:flex;align-items: center;">
                                <van-image width="30"
                                           height="30"
                                           src="https://pic.imgdb.cn/item/619631732ab3f51d91398c6f.jpg"
                                           round/>
                                <div style="margin-left: 15px;">支付宝</div>
                            </div>
                        </template>
                        <template #right-icon>
                            <van-radio name="alipay" checked-color="#F93E5B"/>
                        </template>
                    </van-cell>

                </van-cell-group>
            </van-radio-group>

        </div>


        <van-submit-bar
            :loading="loading"
            :decimal-length="2"
        >
            <template #default>
                <div class="van-submit-bar__text">
                    <span class="van-submit-bar__price">¥<span class="van-submit-bar__price-integer">{{ price }}</span>.00</span>
                </div>
            </template>
            <template #button>
                <van-button @click="onSubmit" color="#FB3E5B">
                    提交订单
                </van-button>
            </template>
        </van-submit-bar>
    </div>
</template>

<script>


import {useRoute, useRouter} from "vue-router";
import {computed, reactive, toRefs} from "vue";
import {storeOrder} from "../../api/api";
import {Toast} from 'vant'
import {getChosenLocation} from "../../api/location";
import {getRandomArbitrary} from "../../api/common";
import {addOrder, orderList} from "../../api/order";

export default {
    name: 'order_create',
    setup() {
        const route = useRoute();
        const router = useRouter();
        const chosenLocation = getChosenLocation();

        const data = reactive({
            loading: false,
            count: route.query.count,
            payment: 'wechat',
            location: {
                name: '',
                phone: '',
                address: ''
            },
            list: [],
        })

        let sku = JSON.parse(route.query?.sku);
        let price = computed(() => {
            return route.query.price * data.count;
        })

        const onSubmit = async () => {
            if (!chosenLocation) {
                Toast('请输入收货人信息');
                return;
            }

            Toast.loading({
                message: '下单中...',
                forbidClick: true,
            });
            data.loading = true;

            let result = await storeOrder({
                product_id: route.query.product_id,
                product_sku: route.query.sku,
                count: data.count,
                price: price.value,
                payment: data.payment,
                'custom_info': JSON.stringify({
                    '收货人': chosenLocation.name,
                    '收货人电话': chosenLocation.phone,
                    '收货人地址': chosenLocation.detail
                })
            });
            data.loading = false;
            Toast.clear();
            let id = result.id;
            addOrder(id);
            window.location.href = `/api/pay?order_id=${result.id}`;
        }
        const handleLocation = () => {
            if (chosenLocation) {
                router.push({path: '/location'})
            } else {
                router.push({
                    path: '/location/create',
                    query: {
                        action: 'chose',
                    }
                })
            }
        }

        console.log("getRandomArbitrary(1, 24)", getRandomArbitrary(1, 24));
        return {
            ...toRefs(data),
            onSubmit,
            handleLocation,
            chosenLocation,
            price,
            hour: Math.floor(getRandomArbitrary(1, 24)),
            query: {
                ...route.query,
                sku: Object.values(sku).join('/'),

            },
        }
    }
}
</script>

<style scoped lang="less">
.nut-navbar {
    margin-bottom: 0;
}

.payment {
    margin-top: 15px;
}

.card-product {
    background-color: #fff;
    margin: 0;

    .card-product_title {
        font-size: 16px;
    }

    .card-product_sku {
        display: inline-block;
        font-size: 15px;
        background-color: #FAFAFA;
        color: #ABABAB;
        padding: 3px 8px;
        margin: 5px 0;
    }

    .van-card__price-integer {
        font-size: 16px;
    }

    .card-product_text {
        font-size: 15px;
        margin: 7px 0;

        &.red {
            color: #D78161;
            font-size: 14px;
        }

        &.tags {
            color: #CF8062;
            font-size: 14px;

            span {
                border: 1px solid #CF8062;
                border-radius: 3px;
                display: inline-block;
                padding: 2px 5px;
                margin-right: 8px;
            }
        }
    }
}


.location_title {
    strong {
        font-size: 15px;
    }
}

.location_label {
    font-size: 14px;
    color: #333;
}


.nav_title {
    display: flex;
    align-items: center;
    justify-content: center;
}

.van-submit-bar {
    padding: 10px 0;
}

.van-submit-bar__text {
    text-align: left;
}

.order-title {
    margin-top: 15px;
    background-color: #fff;
    font-size: 16px;
    padding: 15px 20px;
    color: #333;

}
</style>

<style lang="less">
.van-location-card--add .van-cell__left-icon {
    color: #B1B0B6;
    font-size: 25px;
    margin-right: 10px;
}

.van-card__bottom {
    margin-top: 15px;
}
</style>
