<template>
    <div class="order_index">
        <van-skeleton :row="20" :loading="loading">
            <van-nav-bar fixed placeholder left-arrow title="全部订单" @click-left="$router.back()"/>
            <van-list
                v-model="loading"
                :finished="finished"
                finished-text="没有更多了"
                @load="pullOrderId"
            >
                <OrderItem :product="item" v-for="item in list" :key="item.id"/>
            </van-list>
        </van-skeleton>

    </div>
</template>

<script>
import {orderIdStr} from "../../api/order";
import {getOrderList} from "../../api/api";
import {reactive, toRefs} from "vue";
import OrderItem from "./OrderItem";

export default {
    name: 'order_index',
    components: {
        OrderItem
    },
    setup() {
        const data = reactive({
            list: [],
            loading: false,
            finished: false,
        });


        let id = orderIdStr();


        const pullOrderId = async () => {
            if (id) {
                data.loading = true;
                let result = await getOrderList(id);

                data.loading = false;
                data.list = result.data.data.map((item) => {
                    return {
                        ...item,
                        custom_info: JSON.parse(item.custom_info),
                        snapshot: [].concat(JSON.parse(item.snapshot)),
                    }
                });

                if (result.data.last_page >= result.data.current_page) {
                    data.finished = true;
                }

            } else {
                data.finished = true;
            }
        }


        return {
            ...toRefs(data),
            pullOrderId,

        }
    }
}
</script>

<style scoped lang="less">

</style>
