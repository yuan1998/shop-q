<template>
    <div class="product_detail">
        <van-skeleton :row="20" :loading="loading">
            <van-nav-bar fixed placeholder left-arrow title="商品详细" @click-left="$router.back()"/>
            <div class="product_images">
                <van-swipe :autoplay="3000" lazy-render class="product-image_swiper">
                    <van-swipe-item v-for="(image , index) in data.images" :key="index">
                        <img class="product-image" :src="'/storage/' + image.value"/>
                    </van-swipe-item>
                </van-swipe>
            </div>
            <div class="product_info">
                <div class="product_info-price">
                    <div class="product_info-left">

                        <div class="price_text">
                            <span class="syb">¥</span>
                            {{ data.price }}
                        </div>
                    </div>
                    <div class="product_info-right">
                        <div class="sales">
                            已售{{ data.sales }}
                        </div>
                    </div>
                </div>
                <van-image src="https://pic.imgdb.cn/item/6185e0e22ab3f51d915b2074.png"/>
                <div class="product_info-title">
                    {{ data.title }}
                </div>
                <van-divider/>

                <div class="product_info-list">
                    <van-cell is-link>
                        <!-- 使用 title 插槽来自定义标题 -->
                        <template #title>
                            <van-image src="https://pic.imgdb.cn/item/6185e2b92ab3f51d915d0582.png" style="width:70vw;max-width: 700px;"/>
                        </template>
                    </van-cell>
                    <van-cell>
                        <!-- 使用 title 插槽来自定义标题 -->
                        <template #title>
                            <van-image fil="contain" src="https://pic.imgdb.cn/item/6185e3202ab3f51d915d90ab.png" style="width:40vw;max-width: 700px;"/>
                        </template>
                    </van-cell>

                </div>
            </div>
            <div>
                <img src="https://pic.imgdb.cn/item/6186641e2ab3f51d91102b26.png" alt="" class="mc-img">
            </div>
            <div>
                <img src="https://pic.imgdb.cn/item/618664552ab3f51d91108628.png" alt="" class="mc-img">
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
                <div class="product_actions_icon">
                    <van-icon size="20" color="#767676" name="shop-o"/>
                    <div class="icon-text">
                        店铺
                    </div>
                </div>
                <div class="product_actions_icon">
                    <van-icon size="20" color="#767676" name="chat-o"/>
                    <div class="icon-text">
                        客服
                    </div>
                </div>
                <div class="product_actions_icon">
                    <van-icon size="20" color="#767676" name="star-o"/>
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

import {onMounted, reactive, toRefs} from "vue";
import {useRoute, useRouter} from "vue-router";
import {getProductDetail} from "../../api/api";
import {toQueryString} from "../../api/common";
import Sku from './Sku';

export default {
    name: 'product_detail',
    components: {
        Sku
    },
    setup() {
        const route = useRoute();
        const router = useRouter();

        const data = reactive({
            loading: true,
            show: false,
            id: '',
            data: {}
        });


        const productDetail = async (id) => {
            let result = await getProductDetail(id);
            console.log("result", result);
            if (result.status === 0) {
                let resultData = result.data;
                let skus = JSON.parse(resultData.skus);
                console.log("skus", skus);
                data.data = {
                    ...resultData,
                    images: JSON.parse(resultData.images),
                    attributes: JSON.parse(resultData.attributes),
                    skus: skus,
                }
                console.log("data.data", data.data);
            }
        }

        onMounted(async () => {
            data.id = route.params.id;
            console.log("data.id", data.id);
            await productDetail(data.id);
            data.loading = false;
        });

        const send = () => {

        }

        const onClickIcon = () => {

        }
        const onClickButton = () => {

        }
        const showSku = () => {
            data.show = true;
        }
        const buyProduct = (buyData) => {
            console.log("data", buyData);
            let query = {
                sku: JSON.stringify(buyData.select),
                count: buyData.count,
                product_id: data.id,
                image: data.data?.images[0]?.value,
                title: data.data.title,
                price: data.data.price
            };
            router.push({
                path: '/order/create',
                query,
            })

        }

        return {
            ...toRefs(data),
            send,
            onClickButton,
            onClickIcon,
            showSku,
            buyProduct,
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
</style>
<style lang="less">
.price_text {
    flex: none;
    color: red;
    font-size: 26px;
    font-weight: bold;

    .syb {
        font-size: 16px;
    }
}
</style>
