<template>
    <div class="product_container">
        <van-sticky>
            <van-tabs v-model:active="activeName">
                <van-tab title="标签 1" name="a">
                    <van-row gutter="20" class="test_1">
                        <van-col span="12">
                            <div class="product_item">
                                <div class="product_cover">
                                    <van-image
                                        src="https://img01.yzcdn.cn/vant/cat.jpeg"
                                    />
                                </div>
                                <div class="product_meta">
                                    <div class="product_title">
                                        属性设置列所占的宽度百分比。此外，添加 offset 属性可以设置列的偏移宽度，计算方式与 span 相同。
                                    </div>
                                    <div class="product_info">
                                        <div class="product_price">
                                            <span class="syb">¥</span>
                                            2599
                                        </div>
                                        <div class="product_sales">
                                            已售123
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </van-col>
                        <van-col span="12">
                            <div class="product_item">
                                <div class="product_cover">
                                    <van-image
                                        src="https://img01.yzcdn.cn/vant/cat.jpeg"
                                    />
                                </div>
                                <div class="product_title">

                                </div>
                                <div class="product_info">
                                    <div class="product_price">
                                        <div class="syb"></div>
                                    </div>
                                    <div class="product_sales">

                                    </div>
                                </div>
                            </div>
                        </van-col>


                    </van-row>
                </van-tab>
                <van-tab title="标签 2" name="b">内容 2</van-tab>
                <van-tab title="标签 3" name="c">内容 3</van-tab>
            </van-tabs>
        </van-sticky>
    </div>
</template>
<script>
import {ref} from "vue";

export default {
    methods: {},
    mounted() {
        // this.cs();
    },
    setup() {
        const activeName = ref('a');
        return {activeName};
    },
}
</script>
<style  lang="less">

.product_container {

    .test_1 {
        padding: 20px;
    }

    .product_item {
        background-color: #fff;
        border-radius: 2px;
    }

    .product_meta {
        padding: 10px;
    }

    .product_title {
        font-size: 18px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        overflow:hidden;
        /*! autoprefixer: off */
        -webkit-box-orient: vertical;
    }




    .product_info {
        display: flex;
        padding-top: 15px;


        .product_price {
            flex:auto;
            color:red;
            font-size: 18px;

            .syb {
                font-size: 16px;
            }
        }

        .product_sales {
            flex:none;
            margin-left: auto;
            color: #B2B2B2;
        }

    }
}


</style>
