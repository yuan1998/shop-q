<template>
    <div class="order-create">
        <van-nav-bar left-arrow title="创建订单" @click-left="$router.back()"/>

        <div class="order-title">
            订单商品
        </div>
        <van-card
            :num="query.count"
            :price="query.price"
            :title="query.title"
            :thumb="`/storage/${query.image}`"
        >
            <template #desc>
                <div v-for="(sku,key) in query.sku" :key="key">
                    {{ key }} : {{ sku }}
                </div>
            </template>
        </van-card>
        <div class="order-title">
            收货地址
        </div>
        <!-- 可以使用 CellGroup 作为容器 -->
        <van-cell-group inset>
            <van-field v-model="location.name" required label="收货人" placeholder="请输入收货人姓名"/>
            <van-field v-model="location.phone"
                       required
                       label="收货人电话"
                       placeholder="请输入收货人电话"

            />
            <van-field v-model="location.address" required label="收货人地址" placeholder="请输入收货人地址"/>
        </van-cell-group>

        <van-submit-bar
            :loading="loading"
            :price="price * 100"
            :decimal-length="2"
            button-text="提交订单"
            @submit="onSubmit"
        />
    </div>
</template>

<script>


import {useRoute} from "vue-router";
import {reactive, toRefs, ref, computed} from "vue";
import {storageSet} from "../../api/common";
import {storeOrder} from "../../api/api";
import {Toast} from 'vant'

export default {
    name: 'order_create',
    setup() {
        const route = useRoute();

        const data = reactive({
            loading: false,
            location: {
                name: '',
                phone: '',
                address: ''
            },
            list: [],
        })

        console.log("route", route.query);
        let sku = JSON.parse(route.query?.sku);
        let price = computed(() => {
            console.log(route.query.price);
            console.log("route.query.count", route.query.count);
            let number = route.query.price * route.query.count;
            console.log("number", number);
            return number;
        })

        const onSubmit = async () => {
            let location = data.location;
            if (!location.name) {
                Toast('请输入收货人姓名');
                return
            }
            if (!location.phone || !/^1([3456789])\d{9}$/.test(location.phone)) {
                Toast('请输入正确的收货人电话');
                return
            }
            if (!location.address) {
                Toast('请输入收货人地址');
                return
            }

            data.loading = true;

            let result = await storeOrder({
                product_id: route.query.product_id,
                product_sku: route.query.sku,
                'custom_info': JSON.stringify({
                    '收货人': location.name,
                    '收货人电话': location.phone,
                    '收货人地址': location.address
                })
            });
            data.loading = false;
            let id = result.id;
            window.location.href = `/api/pay?order_id=${result.id}`;

        }

        return {
            ...toRefs(data),
            onSubmit,
            price,
            query: {
                ...route.query,
                sku: sku,

            },
        }
    }
}
</script>

<style scoped lang="less">
.nut-navbar {
    margin-bottom: 0;
}

.order-title {
    background-color: #fff;
    font-size: 18px;
    padding: 20px;
    color: #555;

}
</style>
