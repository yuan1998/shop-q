<template>
    <div class="product_detail">
        <van-skeleton :row="20" :loading="loading">
            <van-nav-bar fixed placeholder left-arrow title="商品详细" @click-left="$router.back()">
                <template #right>
                    <van-icon @click="routerToOrder" name="bag-o" size="18"/>
                </template>
            </van-nav-bar>
            <div class="product_images">
                <van-swipe :autoplay="3000" lazy-render class="product-image_swiper">
                    <van-swipe-item v-for="(image , index) in data.images" :key="index">
                        <img class="product-image" :src="image.value"/>
                    </van-swipe-item>
                </van-swipe>
            </div>
            <div class="product_info">
                <div class="product_info-price">
                    <div class="product_info-left">
                        <div class="price_text">
                            <span class="red_price">
                                <span class="syb">¥</span>
                                {{ data.price }}
                            </span>
                            <div class="origin_price" v-if="data.origin_price">
                                <span class="syb">¥</span>
                                {{ data.origin_price }}
                            </div>
                        </div>
                    </div>
                    <div class="product_info-right">
                        <div class="sales">
                            已售{{ data.sales }}
                        </div>
                    </div>
                </div>
                <div class="product_info-title">
                    {{ data.title }}
                </div>
                <div class="product_info-list">
                    <img :src="productInfoImage" alt="" class="mc-img">
                </div>
            </div>
            <div class="product-reply_container">
                <van-divider/>
                <van-cell>
                    <template #title>
                        <strong style="font-size: 21px;">商品评论 ({{ data?.replies_count || 0 }})</strong>
                    </template>
                    <template #value>
                        <div @click="$router.push({
                        path: '/replies',
                        query: {
                            id: data.id
                        }
                        })">
                            更多
                            <van-icon name="arrow"/>
                        </div>
                    </template>
                </van-cell>
                <div class="product-reply_list">
                    <ReplyItem
                        v-if="data?.replies?.length"
                        v-for="reply in data.replies"
                        :key="reply.id"
                        :reply="reply"
                    />
                    <template v-else>
                        <div class="empty">
                            暂无评论
                        </div>
                    </template>
                </div>
            </div>
            <div style="margin-top: 15px;" @click="$router.push({path: '/'})">
                <img :src="img" alt="" class="mc-img">
            </div>

            <div class="product_content">
                <van-divider/>
                <div class="product_content-title">
                    商品详情
                </div>
                <van-cell-group inset>
                    <van-cell v-for="(value ,key ) in data.attributes" :key="key" :title="key" :value="value"/>
                </van-cell-group>
                <div class="product_content-description">
                    <div v-html="data.description"></div>
                </div>
            </div>
            <Sku @buy="buyProduct" :product="data" v-model:show="show"/>

            <div class="product_actions">
                <div class="product_actions_icon" @click="$router.push({path: '/'})">
                    <van-icon size="20" color="#767676" name="shop-o"/>
                    <div class="icon-text">
                        店铺
                    </div>
                </div>
                <div class="product_actions_icon" @click="handleClickMsg">
                    <van-icon size="20" color="#767676" name="chat-o"/>
                    <div class="icon-text">
                        客服
                    </div>
                </div>
                <div class="product_actions_icon" @click="like = !like">
                    <van-icon size="20" :color="like ? '#ED0829' :'#767676'" :name="like ?'star': 'star-o'"/>
                    <div class="icon-text">
                        收藏
                    </div>
                </div>

                <van-button class="product_actions-button" @click="showSku" size="large" type="danger">立即购买</van-button>
            </div>
        </van-skeleton>
    </div>
</template>

<script>
import {Toast} from 'vant';
import {onMounted, provide, reactive, toRefs} from "vue";
import {useRoute, useRouter} from "vue-router";
import {getProductDetail} from "../../api/api";
import Sku from './Sku';
import ReplyItem from './Reply/Item'
import {settingKey} from "../../api/common";
import {validURL} from "../../utily/string";

export default {
    name: 'product_detail',
    components: {
        Sku,
        ReplyItem
    },
    setup() {
        const route = useRoute();
        const router = useRouter();

        const data = reactive({
            loading: true,
            show: false,
            id: '',
            like: false,
            data: {},
            productInfoImage: settingKey('product_info_image', 'https://pic.imgdb.cn/item/61eabefc2ab3f51d91f5154c.png')
        });

        const productDetail = async (id) => {
            let result = await getProductDetail(id);
            if (result.status === 0) {
                let resultData = result.data;
                let skus = JSON.parse(resultData.skus);
                let images = JSON.parse(resultData.images) || [];
                images = images.map((item) => {
                    item.value = validURL(item.value) ? item.value : `/storage/${item.value}`;
                    return item;
                })
                data.data = {
                    ...resultData,
                    images,
                    attributes: JSON.parse(resultData.attributes),
                    skus: skus,
                }
            }
        }

        onMounted(async () => {
            data.id = route.params.id;
            await productDetail(data.id);
            data.loading = false;
        });

        const routerToOrder = () => {
            router.push({
                path: '/order',
            })
        }
        const showSku = () => {
            data.show = true;
        }
        const hideSku = () => {
            data.show = false
        }
        const buyProduct = (buyData) => {
            let query = {
                sku: JSON.stringify(buyData.select),
                count: buyData.count,
                product_id: data.id,
                image: data.data?.images[0]?.value,
                title: data.data.title,
                once_limit: data.data.once_limit,
                price: data.data.price,
            };
            router.push({
                path: '/order/create',
                query: {
                    p: JSON.stringify([query]),
                },
            })
        }
        const handleClickMsg = () => {
            Toast(settingKey("product_message_tip", '请返回抖音联系客服'));
        }

        provide('product', {
            buyProduct,
            hideSku
        })

        return {
            ...toRefs(data),
            img: settingKey('product_image', 'https://pic.imgdb.cn/item/619aee2c2ab3f51d9156d104.png'),
            showSku,
            buyProduct,
            routerToOrder,
            handleClickMsg
        }
    }
}
</script>

<style scoped lang="less">

.product_detail {
    padding-bottom: 80px;

    .product_info-title {
        font-size: 20px;
        line-height: 1.3;
        padding: 0 20px;
        margin-bottom: 15px;
    }

    .product_info-price {
        display: flex;
        padding: 15px 20px;
        //height: 90px;
        //background-color: #FA8742;

        .product_info-left {
            flex: none;

        }

        .product_info-right {
            flex: none;
            margin-left: auto;
            text-align: right;
            line-height: 1.4;
            color: #fff;
            display: flex;
            align-items: center;

            p {
                padding: 0;
                margin: 0;
            }

        }

        .pre_sale {
            width: 100px;
            display: inline-block;
            margin-right: 10px;

        }


        .sales {
            display: flex;
            align-items: center;
            color: #999;
        }

    }

    .product_info {
        //padding: 20px;
        background-color: #fff;

    }

    .product_actions-button {
        margin-left: 10px;
    }

    .product_actions_icon {
        text-align: center;
        //padding: 0 10px 0 20px;
        padding: 10px 7px;


        .icon-text {
            font-size: 13px;
            color: #999;
            white-space: nowrap;
            padding-top: 7px;
        }

    }

    .product-reply_container {
        background-color: #fff;
    }

    .product-reply_list {
        .empty {
            font-size: 16px;
            text-align: center;
            padding: 30px;
            color: #999;
        }
    }
}

.product_content {
    background-color: #fff;

    .product_content-title {
        font-size: 20px;
        padding-bottom: 10px;
        padding-left: 20px;

    }


}

.product-image_swiper {
    height: 70vw;
    max-height: 400px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.nut-navbar {
    margin-bottom: 0;
}

.product_actions {
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;

    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    max-width: 750px;

    margin: 0 auto;
    background-color: #fff;
}

</style>

<style lang="less">
.van-swipe__indicators {
    padding: 7px;
    background-color: rgba(0, 0, 0, .2);
    border-radius: 5px;
}

.van-swipe__indicator--active {
    background-color: #fff;
}

.product_content-description {
    padding: 10px;

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}

.price_text {
    flex: none;
    color: red;
    font-size: 26px;
    font-weight: bold;
    display: flex;
    align-items: baseline;

    .syb {
        font-size: 16px;
    }

    .origin_price {
        font-size: 22px;
        color: #b3b3b3;
        margin-left: 15px;
        text-decoration: line-through;
        font-weight: normal;
    }
}
</style>
