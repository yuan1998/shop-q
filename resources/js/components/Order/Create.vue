<template>
    <div class="order-create">
        <van-nav-bar fixed placeholder left-arrow title="创建订单" @click-left="$router.push({path:'/'})">
            <template #title>
                <div class="nav_title">
                    <van-image
                        width="30px"
                        height="30px"
                        fit="cover"
                        round
                        src="https://api.uomg.com/api/rand.avatar?sort=%E7%94%B7&format=images"
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
            <CreateProductItem v-for="(product,index) in productData"
                               :product="product"/>

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
                <van-cell-group class="flex" :class="reversePayment && 'reverse'">
                    <van-cell v-if="!disableWechat" clickable @click="payment = 'wechat'">
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
                    <van-cell v-if="!disableAlipay" clickable @click="payment = 'alipay'">
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
                    <span class="van-submit-bar__price">¥<span class="van-submit-bar__price-integer">{{ price }}</span></span>
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

import lodash from 'lodash';
import {useRoute, useRouter} from "vue-router";
import {computed, onMounted, reactive, ref, toRefs} from "vue";
import {storeOrder, storeProductsOrder} from "../../api/api";
import {Toast} from 'vant'
import {getChosenLocation} from "../../api/location";
import {getRandomArbitrary, stringToBoolean} from "../../api/common";
import {addOrder} from "../../api/order";
import CreateProductItem from './CreateProductItem';
import {cartDelete} from "../../api/cart";

export default {
    name: 'order_create',
    components: {
        CreateProductItem
    },
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
        const productData = ref([]);

        const reversePayment = !!lodash.get(window._setting_, 'payment_sort', false);
        let price = computed(() => {
            let total = 0;
            productData.value.forEach((row) => {
                total += row.price * row.count;
            })
            return total.toFixed(2);
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
            let isCart = [];
            let product = productData.value.map((row) => {
                row.ID && isCart.push(row.ID);

                return {
                    id: row.product_id,
                    sku: row.sku,
                    image: row.image,
                    title: row.title,
                    price: row.price,
                    count: row.count,
                }
            })
            data.loading = true;
            let result = await storeProductsOrder({
                product,
                payment: data.payment,
                custom_info: JSON.stringify({
                    '收货人': chosenLocation.name,
                    '收货人电话': chosenLocation.phone,
                    '收货人地址': chosenLocation.detail
                })
            });
            data.loading = false;
            Toast.clear();
            let id = result.id;
            isCart.length && cartDelete(isCart);

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
        const disableAlipay = computed(() => {
            return lodash.get(window._setting_, 'disable_alipay', stringToBoolean(process.env.MIX_DISABLE_ALIPAY))
        })
        const disableWechat = computed(() => {
            return lodash.get(window._setting_, 'disable_wechat', stringToBoolean(process.env.MIX_DISABLE_WECHAT))
        });

        onMounted(() => {
            if (disableWechat.value || disableAlipay.value) {
                data.payment = disableWechat.value ? 'alipay' : 'wechat';
            } else {
                data.payment = reversePayment ? 'alipay' : 'wechat';
            }

            let d = JSON.parse(route.query.p) || [];
            productData.value = d.map((row) => {
                try {
                    row.sku = JSON.parse(row.sku);
                } catch (e) {

                }
                return row;
            })
        });

        return {
            ...toRefs(data),
            disableAlipay,
            disableWechat,
            reversePayment,
            onSubmit,
            handleLocation,
            chosenLocation,
            price,
            hour: Math.floor(getRandomArbitrary(1, 24)),
            productData,
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

    .flex {
        display: flex;
        flex-direction: column;

        &.reverse {
            flex-direction: column-reverse;
        }
    }
}

.order-create {
    padding-bottom: 100px;
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
