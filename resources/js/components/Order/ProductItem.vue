<template>
    <div class="product_item">
        <div class="product_thumb">
            <van-image width="80" height="80" fit="cover" :src="'/storage/' + image"/>
        </div>
        <div class="product_content">
            <div class="product_info">
                <div class="product_title">
                    {{ product.title }}M是數字的最大數(精度)。其範圍為1~65(在較舊的MySQL版本中,允許的範圍是1~254),M 的預設值是10。
                </div>
                <div class="product_sku">
                    <div class="sku">
                        {{ sku }}
                    </div>
                </div>
                <div class="product_text">
<!--                    <span>-->
<!--                        7天无理由退货-->
<!--                    </span>-->
                </div>
            </div>
            <div class="product_price">
                <div class="price">
                    ¥ {{ product.price }}
                </div>
                <div class="count">
                    x{{ product.count }}
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import lodash from 'lodash';

export default {
    name: 'order_product_item',
    props: ['product'],
    setup(props) {
        const {product} = props;
        const image = lodash.get(JSON.parse(product.images), '0.value');
        const sku = lodash.values(JSON.parse(product.sku)).join('/')

        return {
            product,
            image,
            sku
        }
    }
}
</script>

<style scoped lang="less">

.product_item {
    display: flex;
    padding: 15px;
    max-width: 100vw;

    .product_thumb {
        flex: none;
    }

    .product_sku,
    .product_title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product_title {
        //display: inline-block;
        width: 100%;
    }

    .product_sku {
        display: inline-block;
        background-color: #FAFAFA;
        color: #777777;
        padding: 2px 10px;
        font-size: 14px;
        margin-top: 8px;
        margin-bottom: 6px;
    }

    .product_text {
        span {
            display: inline-block;
            color: #CD815F;
            padding: 2px 5px;
            border: 1px solid #CD815F;
            border-radius: 2px;
            font-size: 12px;
        }
    }

    .product_content {
        flex: auto;
        display: flex;
        overflow: hidden;
        padding-left: 10px;

        .product_info {
            flex: auto;
            overflow: hidden;

        }

        .product_price {
            flex: none;
            text-align: right;
            color: #777777;
            line-height: 1.8;
            padding-left: 10px;

        }
    }

}

</style>
