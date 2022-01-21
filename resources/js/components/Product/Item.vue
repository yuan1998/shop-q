<template>
    <div id="product_item" class="product_item">
        <router-link :to="'/detail/' +id">
            <div class="product_cover">
                <van-image
                    style="height:40vw;max-height: 400px;width: 100%;"
                    fit="cover"
                    :src="`/storage/${image}`"
                />
            </div>
            <div class="product_meta">
                <div class="product_title">
                    {{ title }}
                </div>
                <div class="product_info">
                    <div class="product_price">
                        <span class="red_price">
                            <span class="syb">¥</span>
                            {{ price }}
                        </span>
                        <span v-if="origin_price" class="origin_price">
                            <span class="syb">¥</span>
                            {{ origin_price }}
                        </span>
                    </div>
                    <div class="product_sales">
                        已售{{ sales }}
                    </div>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>

export default {
    name: 'product_item',
    props: ['data'],
    setup(props) {

        let {data} = props;

        return {
            ...data
        }
    }
}
</script>

<style scoped lang="less">

.product_item {
    background-color: #fff;
    border-radius: 2px;
    margin-bottom: 20px;
}

.product_meta {
    padding: 10px;
}

.product_title {
    font-size: 18px;
    overflow: hidden;
    color: #333;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    overflow: hidden;
    /*! autoprefixer: off */
    -webkit-box-orient: vertical;
}

.product_info {
    display: flex;
    padding-top: 15px;


    .product_price {
        flex: auto;
        color: red;
        font-size: 22px;

        .syb {
            font-size: 16px;
        }

        .origin_price {
            margin-left: 10px;
            font-size: 16px;
            color: #b3b3b3;
            text-decoration:line-through;
        }
    }

    .product_sales {
        flex: none;
        margin-left: auto;
        color: #B2B2B2;
    }

}
</style>
