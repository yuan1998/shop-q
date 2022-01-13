<template>
    <van-card class="card-product"
              :thumb="thumb"
    >
        <template #price>
            <div>
                <span class="van-card__price-currency">¥</span>
                <span class="van-card__price-integer">{{ product.price }}</span>
            </div>
        </template>
        <template #title>
            <div class="card-product_title">
                {{ product.title }}
            </div>
        </template>
        <template #desc>
            <div class="card-product_sku">
                {{ sku }}
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
            </div>
        </template>
        <template #num>
            <van-stepper v-model="product.count"/>
        </template>
    </van-card>
</template>
<script setup>
import {computed, defineProps, toRefs} from "vue";

const props = defineProps({
    product: Object,
})
const {product} = toRefs(props);
const thumb = computed(() => {
    let image = product.value.image;
    return /http(s)?\:\/\//.test(image) ? image :
        (/\/storage\//.test(image)  ? image : `/storage/${image}`)
});
const sku = computed(() => {
    let sku = product.value.sku;
    return Object.keys(sku).map((key) => `${key} : ${sku[key]}`).join('\r\n')
});
</script>
<style scoped lang="less">

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

</style>
