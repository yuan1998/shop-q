<template>
    <div class="order_index-card">
        <van-cell :title="item.order_id" :value="statusList[item.status]"/>
        <div class="order_index-card-product">
            <ProductItem v-for="product in item.snapshot" :key="product.id" :product="product"/>
        </div>
        <div class="total_price">
            <span class="total_text">合计</span>
            <strong>¥{{ item.price }}</strong>
        </div>
        <div class="actions">
            <van-button type="default" size="small" @click="deleteOrder(item.order_id)">
                删除订单
            </van-button>
            <van-button type="default" size="small" @click="handleStatusClick()">
                {{
                    buttonText[item.status]
                }}
            </van-button>

            <template v-if="item.status !==1">
                <van-button type="default" size="small" @click="handleLogisticClick()">
                    {{
                        item.logistic_number ? '查看物流' : '未发货'
                    }}
                </van-button>
                <van-button type="default" size="small" @click="handleComplaintClick(item.order_id)">
                    投诉
                </van-button>

            </template>

        </div>
    </div>
</template>

<script>

import {Toast} from "vant";
import {outPayOrder} from "../../api/api";
import ProductItem from "./ProductItem";
import {reactive} from "vue";
import {useRouter} from "vue-router";
import {orderDelete} from "../../api/order";

export default {
    name: '',
    props: ['product'],
    components: {
        ProductItem
    },
    // emits: ['delete-row'],
    setup(props, {emit}) {
        const router = useRouter();
        const {product} = props;
        const item = reactive(product);

        const statusList = {
            1: '未支付',
            2: '支付成功',
            3: '支付失败',
            4: '退货/退款',
            5: '已发货',
            6: '已取消',
        };

        const buttonText = {
            1: '去支付',
            2: '退货/退款',
            3: '去支付',
            4: '退款中',
            5: '已发货',
            6: '订单已取消',
        }

        const toPay = (id) => {
            Toast.loading('获取支付信息...');
            window.location.href = `/api/pay?order_id=${id}`;
        }

        const outPay = async (id) => {
            Toast.loading('请求退款中...');

            let result = await outPayOrder(id);
            console.log("result", result);

            if (result.status === 0) {
                item.status = 4;
                Toast.success(result.msg);
            } else {
                Toast.fail(result.errMsg);
            }
        }

        const handleStatusClick = () => {
            let id = item.order_id;
            switch (item.status) {
                case 1:
                case 3:
                    toPay(id);
                    break;
                case 2 :
                    outPay(id);
                    break;
                default:
                    Toast(statusList[item.status]);
                    break;
            }
        }

        const handleLogisticClick = () => {
            if (item.logistic_number) {
                window.location.href = `https://m.kuaidi100.com/app/query/?com=shunfeng&nu=${item.logistic_number}&coname=px&callbackurl=${window.location.href}`
            }
        }

        const handleComplaintClick = (id) => {
            router.push({
                path: '/complaint',
                query: {
                    order_id: id
                }
            })
        }

        const deleteOrder = (id) => {
            emit('delete-row', id);
        }

        return {
            item,
            statusList,
            buttonText,
            handleStatusClick,
            handleLogisticClick,
            handleComplaintClick,
            deleteOrder
        }
    }
}
</script>

<style scoped lang="less">
.order_index-card {
    margin-top: 15px;
    background-color: #fff;
    padding-bottom: 10px;

    .total_price,
    .actions {
        text-align: right;
        padding-right: 15px;

        .van-button {
            margin-right: 15px;

            &:last-child {
                margin-right: 0;
            }
        }
    }

    .total_price {
        padding: 10px;

        span {
            font-size: 13px;
            color: #777777;
            margin-right: 4px;
        }

        font-size: 18px;
    }
}


</style>
