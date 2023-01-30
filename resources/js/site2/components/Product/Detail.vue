<template>
    <div class="product_detail">
        <van-skeleton :row="20" :loading="loading">
            <van-nav-bar fixed placeholder left-arrow title="商品详细" @click-left="$router.back()"/>
            <van-icon class="cart-icon-btn"
                      @click="routerToCart"
                      color="#ee0a24"
                      name="cart" size="38"/>
            <div class="product_images">
                <van-swipe :autoplay="3000" lazy-render class="product-image_swiper">
                    <van-swipe-item v-for="(image , index) in data.images" :key="index">
                        <img class="product-image" :src="image.value"/>
                    </van-swipe-item>
                </van-swipe>
            </div>
            <div class="product_info">
                <div class="product_info-border">
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
                </div>
            </div>
            <div class="product-reply_container">
                <div class="product_info-border">
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
            </div>
            <div class="product_shop" v-if="img">
                <div class="product_info-border" @click="$router.push({path: '/'})">
                    <img :src="img" alt="" class="mc-img">
                </div>
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
            <Sku :action="skuAction" :product="data" v-model:show="show"/>

            <van-action-bar>
                <van-action-bar-icon icon="shop-o" text="店铺" color="#ee0a24" @click="$router.push({path: '/'})"/>
                <van-action-bar-icon icon="chat-o" text="客服" @click="handleClickMsg"/>
                <van-action-bar-icon :icon="like ?'star': 'star-o'"
                                     :text="like ? '已收藏' : '收藏'"
                                     :color="like ? '#ED0829' :'#ee0a24'"
                                     @click="like = !like"/>
                <van-action-bar-button type="warning" @click="showSku('cart')" text="加入购物车"/>
                <van-action-bar-button type="danger" @click="showSku('buy')" text="立即购买"/>
            </van-action-bar>

        </van-skeleton>
    </div>
</template>

<script>
import {Toast} from 'vant';
import {onMounted, provide, reactive, toRefs} from "vue";
import {useRoute, useRouter} from "vue-router";
import {getProductDetail} from "../../../api/api";
import Sku from './Sku';
import ReplyItem from '../../../components/Product/Reply/Item'
import {settingKey} from "../../../api/common";
import {addProduct} from "../../../api/cart";
import {validURL} from "../../../utily/string";

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
            skuAction: 'cart',
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

        const routerToCart = () => {
            router.push({
                path: '/cart',
            })
        }
        const showSku = (action = 'buy') => {
            data.show = true;
            data.skuAction = action;
        }
        const hideSku = () => {
            data.show = false
        }

        const productData = (queryData) => {
            return {
                sku: JSON.stringify(queryData.select),
                count: queryData.count,
                product_id: data.id,
                image: queryData.selectPhoto || data.data?.images[0]?.value,
                title: data.data.title,
                price: data.data.price,
            };
        }

        const buyProduct = (buyData) => {
            let query = productData(buyData);
            router.push({
                path: '/order/create',
                query: {
                    p: JSON.stringify([query]),
                },
            })
        }

        const cartProduct = (data) => {
            let query = productData(data);
            addProduct(query);
            Toast('已添加到购物车')
            hideSku();
        }

        const handleClickMsg = () => {
            Toast('请返回抖音联系客服');
        }

        provide('product', {
            buyProduct,
            cartProduct,
            hideSku
        })

        onMounted(async () => {
            data.id = route.params.id;
            await productDetail(data.id);
            data.loading = false;
        });


        return {
            ...toRefs(data),
            img: settingKey('product_image', 'https://pic.imgdb.cn/item/619aee2c2ab3f51d9156d104.png'),
            showSku,
            buyProduct,
            routerToCart,
            handleClickMsg
        }
    }
}
</script>

<style scoped lang="less">
.cart-icon-btn {
    position: fixed;
    top: 30vh;
    right: 14px;
    z-index: 1;
}

.product_detail {
    padding-bottom: 80px;
    background-color: #ededed;

    .product_info-title {
        font-size: 20px;
        line-height: 1.3;
        padding: 0 20px 15px;
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

    .product_info-border {
        border-radius: 8px;
        background-color: #fff;
        overflow: hidden;
    }

    .product_info {
        //padding: 20px;
        padding: 10px;
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

    .product_shop,
    .product-reply_container {
        //background-color: #fff;
        padding: 10px;
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
    z-index: 2;
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
