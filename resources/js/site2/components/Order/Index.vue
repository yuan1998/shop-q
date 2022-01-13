<template>
    <div class="order_index">
        <van-skeleton :row="20" :loading="!list && listLoading">
            <van-nav-bar fixed placeholder title="订单列表" >
            </van-nav-bar>
            <div v-if="headerImage" class="header">
                <van-image :src="headerImage"></van-image>
            </div>
            <van-search v-model="searchValue"
                        show-action
                        @search="onSearch"
                        placeholder="请输入收货人电话号码查询订单"

            >
                <template #action>
                    <div @click="onSearch">搜索</div>
                </template>
            </van-search>

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
                        <p>没有更多了</p>
                    </div>
                </template>
            </van-list>
        </van-skeleton>
    </div>
    <Tabbar/>

</template>

<script>
import lodash from 'lodash'
import {mergeOrder, orderDelete, orderIdStr} from "../../../api/order";
import {getOrderList, searchOrderByPhone} from "../../../api/api";
import {computed, provide, reactive, toRefs} from "vue";
import {Toast, Dialog} from 'vant';
import OrderItem from "../../../components/Order/OrderItem";
import Tabbar from '../layouts/Tabbar.vue'
import {settingKey} from "../../../api/common";

export default {
    name: 'order_index',
    components: {
        OrderItem,
        Tabbar,
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

        const onSearch = async () => {
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

        const headerImage = computed(() => {
            let image = settingKey('order_header_image');
            if (!image) return '';
            return /http(s)?\:\/\//.test(image) ? image :
                (/\/storage\//.test(image)  ? image : `/storage/${image}`)
        })

        provide('order-index', {deleteOrder});

        return {
            ...toRefs(data),
            pullOrderId,
            onSearch,
            deleteOrder,
            headerImage,
        }
    }
}
</script>

<style scoped lang="less">

</style>
