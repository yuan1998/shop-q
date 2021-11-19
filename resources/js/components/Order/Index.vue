<template>
    <div class="order_index">
        <van-skeleton :row="20" :loading="loading">
            <van-nav-bar fixed placeholder left-arrow title="全部订单" @click-left="$router.back()">
                <template #right>
                    <van-icon @click="onClickRight" name="search" size="18"/>
                </template>
            </van-nav-bar>
            <van-list
                v-model="loading"
                :finished="finished"
                finished-text="没有更多了"
                @load="pullOrderId"
            >
                <OrderItem :product="item" v-for="item in list" :key="item.id"/>
            </van-list>
            <van-action-sheet v-model:show="show"
                              description="输入手机号码搜索订单">
                <div class="content">
                    <van-search v-model="searchValue" placeholder="请输入收货人电话号码"/>
                    <div class="van-action-sheet__gap"></div>
                    <button @click="onCancel" type="button" class="van-action-sheet__cancel">
                        {{
                            searchValue ? '查询' : '取消'
                        }}
                    </button>
                </div>
            </van-action-sheet>
        </van-skeleton>
    </div>
</template>

<script>
import {existsOrder, mergeOrder, orderIdStr, truncateOrder} from "../../api/order";
import {getOrderList, searchOrderByPhone} from "../../api/api";
import {onMounted, reactive, toRefs} from "vue";
import {Toast} from 'vant';
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
            show: false,
            searchValue: '',
        });


        const pullOrderId = async () => {
            let id = orderIdStr();
            console.log("id", id);

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
        const onClickRight = () => {
            data.show = true;
        };
        const onCancel = async () => {
            const {searchValue} = data;
            if (searchValue) {
                if (!/^[1][345789][0-9]{9}$/.test(searchValue)) {
                    Toast.fail('请输入正确的电话号码');
                    return;
                }

                Toast.loading('获取订单中,请稍等...');
                let result = await searchOrderByPhone(searchValue);
                mergeOrder(result.data);
                Toast.success('获取订单中成功');
                data.finished = false;
                pullOrderId();
            }

            data.show = false;
        };

        return {
            ...toRefs(data),
            pullOrderId,
            onClickRight,
            onCancel,
        }
    }
}
</script>

<style scoped lang="less">

</style>
