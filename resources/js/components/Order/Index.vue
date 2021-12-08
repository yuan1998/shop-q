<template>
    <div class="order_index">
        <van-skeleton :row="20" :loading="!list && listLoading">
            <van-nav-bar fixed placeholder title="全部订单">
                <template #left>
                    <van-icon @click="$router.push({path: '/'})" name="shop" size="18"/>
                </template>
                <template #right>
                    <van-icon @click="onClickRight" name="search" size="18"/>
                </template>
            </van-nav-bar>
            <van-list
                v-model="listLoading"
                :finished="finished"
                @load="pullOrderId"
            >
                <OrderItem :product="item"
                           v-for="item in list"
                           :key="item.id"
                           @delete-row="deleteOrder"/>

                <template #finished>
                    <div style="font-size: 16px;">
                        <p>Q: 为什么没有或者缺失了我的订单?</p>
                        <p>A: 系统网络波动会导致本地订单数据丢失
                            <br>
                            可以点击下方文字或者右上角的查询图标手动输入收货人电话
                            <br>
                            <span style="color: #4aa0e6;" @click="onClickRight">获取订单</span>
                        </p>
                        <p>
                            官方客服电话: {{ setting.customer_phone }}
                        </p>
                        <p>
                            官方客服微信: {{ setting.customer_wechat }}
                        </p>

                    </div>
                </template>
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
import lodash from 'lodash'
import {existsOrder, mergeOrder, orderDelete, orderIdStr, truncateOrder} from "../../api/order";
import {getOrderList, searchOrderByPhone} from "../../api/api";
import {onMounted, provide, reactive, toRefs} from "vue";
import {Toast, Dialog} from 'vant';
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
            listLoading: false,
            finished: false,
            show: false,
            searchValue: '',
            currentPage: null,
        });

        const pullOrderId = async (page) => {
            page = page || !data.currentPage ? 1 : data.currentPage + 1;
            let id = orderIdStr();

            if (id) {
                data.listLoading = true;
                let result = await getOrderList(id, page);
                let currentPage = result.data.current_page;

                data.listLoading = false;
                let items = result.data?.data?.map((item) => {
                    return {
                        ...item,
                        custom_info: JSON.parse(item.custom_info),
                        snapshot: [].concat(JSON.parse(item.snapshot)),
                        currentPage,
                    }
                });

                let collection = lodash.uniqBy(data.list.concat(items), 'order_id');
                data.list = lodash.sortBy(collection, 'id').reverse();
                data.currentPage = currentPage;

                if (result.data.last_page <= currentPage) {
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
                await pullOrderId(1);
            }

            data.show = false;
        };

        const deleteOrder = (id, page = 1) => {
            Dialog.confirm({
                title: '删除订单',
                message: '是否要删除订单',
                beforeClose: async (action) => {
                    if (action === 'confirm') {
                        data.list = data.list.filter((item) => item.order_id !== id);
                        orderDelete(id);
                        await pullOrderId(page);
                        Toast.success('订单删除成功.')
                    }

                    return true;
                }
            });
        }
        provide('order-index', {deleteOrder});

        return {
            ...toRefs(data),
            pullOrderId,
            onClickRight,
            onCancel,
            deleteOrder,
            setting: window._setting_,
        }
    }
}
</script>

<style scoped lang="less">

</style>
