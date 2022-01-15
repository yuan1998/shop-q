<template>
    <div class="cart-container">
        <van-nav-bar fixed placeholder left-arrow title="购物车" @click-left="$router.back()"/>
        <div class="empty-cart" v-if="!carts.length">
            <img src="https://pic.imgdb.cn/item/61dea7f82ab3f51d91894a41.png" alt="" class="mc-img">
            <p>
                购物车空空如也
                <router-link to="/">快去逛逛吧</router-link>
            </p>
        </div>
        <van-checkbox-group v-else class="cart-list" v-model="cartCheck">
            <van-swipe-cell v-for="item in carts"
                            :key="item.ID">
                <div class="cart-item">
                    <div class="cart-checkbox">
                        <van-checkbox :name="item.ID"/>
                    </div>
                    <van-card
                        class="cart-content"
                        :num="item.count"
                        :price="item.price"
                        :desc="item.sku_text"
                        :title="item.title"
                        :thumb="item.image"
                        @click="$router.push(`/detail/${item.product_id}`)"
                    />
                </div>
                <template #right>
                    <van-button square
                                text="删除"
                                type="danger"
                                class="delete-button"
                                @click="removeProduct(item.ID)"
                    />
                </template>
            </van-swipe-cell>
        </van-checkbox-group>
    </div>
    <van-submit-bar :price="totalPrice * 100"
                    :disabled="disabled"
                    button-text="提交订单"
                    @submit="onSubmit">
        <van-checkbox @click="checkAllChange" v-model="checkAll">全选</van-checkbox>
    </van-submit-bar>
</template>
<script setup>
import {Toast} from 'vant';
import {computed, onMounted, ref, watch} from "vue";
import {cartDelete, cartList} from "../../../api/cart";
import {useRouter} from "vue-router";

const router = useRouter();

const carts = ref([]);
const cartCheck = ref([]);
const checkAll = ref(false);

const initCarts = () => {
    carts.value = cartList().map((row) => {
        row.sku = JSON.parse(row.sku);
        row.sku_text = Object.keys(row.sku).map((key) => `${key} : ${row.sku[key]}`).join('\r\n');
        return row;
    });
    console.log("carts.value", carts.value);
}

const removeProduct = (id) => {
    cartDelete(id);
    Toast('删除商品成功');
    initCarts();
}

const checkedProduct = computed(() => {
    if (!cartCheck.value.length)
        return [];
    return carts.value.filter((product) => cartCheck.value.includes(product.ID));
});

const totalPrice = computed(() => {
    let total = 0;
    checkedProduct.value.forEach((product) => {
        total += (product.price * product.count);
    });
    return total;
})

const disabled = computed(() => {
    return !cartCheck.value.length;
})

const checkAllChange = () => {
    if (checkAll.value)
        cartCheck.value = carts.value.map((cart) => cart.ID);
    else
        cartCheck.value = [];
}

const onSubmit = () => {
    let products = checkedProduct.value;
    if (!products.length) {
        Toast('请选择需要下单的商品')
        return;
    }

    router.push({
        path: '/order/create',
        query: {
            p:  JSON.stringify(products)
        },
    })
};

watch(cartCheck, (val) => {
    if (val.length === carts.value.length) checkAll.value = true;
    else if (checkAll.value) checkAll.value = false;
})

onMounted(() => {
    initCarts();
})


const onClickLink = () => Toast('修改地址');
</script>
<style scoped lang="less">
.cart-list {
    display: flex;
    flex-direction: column;
}

.cart-item {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    .cart-content {
        flex: auto;
        overflow: hidden;
    }

    .cart-checkbox {
        flex: none;
        padding-left: 15px;
    }
}

.empty-cart {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding-top: 100px;

    img {
        width: 50%;
    }

    p {
        padding-top: 30px;
        color: #777;
    }
}

.van-swipe-cell__right button {
    height: 100%;
}

</style>
