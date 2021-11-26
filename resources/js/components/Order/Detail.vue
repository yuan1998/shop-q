<template>
    <div class="order_detail">
        <van-nav-bar fixed placeholder left-arrow title="订单详情" @click-left="$router.back()"/>
        <van-skeleton :row="20" :loading="!order && loading">
            <template v-if="order">
                <div class="order_status">
                    <div class="status_title">
                        <van-icon name="info-o" color="#fff"/>
                        {{
                            order.return_status ? returnStatusList[order.return_status] : titleStatusText[order.status]
                        }}
                    </div>
                    <div class="status_info">
                        {{ order.return_status ? returnInfoText[order.return_status] : infoStatusText[order.status] }}
                    </div>
                </div>
                <div class="order-detail_location">
                    <van-cell icon="location"
                              :border="false"
                              size="large"
                              value-class="van-concat-card__value"
                              class="van-cell--center van-cell--clickable van-cell--borderless van-contact-card van-location-card--add"
                    >
                        <template #icon>
                            <van-icon name="location-o" color="#767676" size="25" style="margin-right: 20px;"/>
                        </template>
                        <template #title>
                            <div class="location_title"><strong>哈哈哈</strong> 13112344321
                            </div>
                        </template>
                        <template #label>
                            <div class="location_label">
                                专业咨询预约挂号,专业咨询预约挂号,专业咨询预约挂号
                            </div>
                        </template>
                    </van-cell>
                </div>
                <div class="order-detail_product">
                    <OrderItem :product="order" :hide-total="true" :hide-action="true"/>
                </div>

                <div class="order-detail_order_info mt-15">
                    <van-cell-group title="" size="large">
                        <van-cell  size="large" title="发货单号" :label="order.logistic_number">
                            <template #value>
                                <van-button type="default" @click="checkLogistic">
                                    查快递
                                </van-button>
                            </template>
                        </van-cell>
                    </van-cell-group>
                </div>

                <div class="order-detail_gird">
                    <div @click="customerClick('商家')">
                        <img src="https://pic.imgdb.cn/item/619f3c852ab3f51d911238c0.jpg" alt="" class="mc-img">
                    </div>
                    <div @click="customerClick('官方')">
                        <img src="https://pic.imgdb.cn/item/619f3c852ab3f51d911238c4.jpg" alt="" class="mc-img">
                    </div>
                </div>


                <div class="order-detail_total">
                    <div class="total_status">
                        {{ statusList[order.status] }}
                    </div>
                    <div class="total_price">
                    <span class="count">
                        共{{ order?.snapshot?.length || 1 }}件商品
                    </span>
                        <div class="price">
                            ¥ {{ order.price }}
                        </div>
                    </div>
                </div>


                <div v-if="order.return_status" class="order-detail_return_info mt-15">
                    <van-cell-group title="退货/退款信息" size="large">
                        <van-cell v-if="order.return_reason" size="large" title="退货/退款理由" :label="order.return_reason"/>
                        <van-cell v-if="order.return_location" size="large" title="退回地址" :label="order.return_location"/>
                        <van-cell v-if="order.return_logistics_number" size="large" title="退货单号" :label="order.return_logistics_number"/>

                    </van-cell-group>
                </div>
                <div class="order-detail_footer">
                    <van-button type="default" @click="deleteOrder(order.order_id)">
                        删除订单
                    </van-button>
                    <van-button v-if="!order.return_status || order.return_status == 6" type="default" @click="returnOrder">
                        申请退货退款
                    </van-button>
                    <van-button v-else type="default" @click="handleCancelReturn">
                        取消退货/退款
                    </van-button>
                    <ShipDialog
                        v-if="showShipButton"
                        :order_id="order.order_id"
                        :status="order.return_status"
                        @refresh="refreshOrder"
                    />
                    <van-button v-if="order.status === 1" type="default" @click="toPay">
                        去支付
                    </van-button>
                    <van-button v-if="showComplaintButton" type="default"  @click="handleComplaintClick">
                        投诉
                    </van-button>
                </div>
            </template>
        </van-skeleton>

    </div>
</template>

<script>

import {useRoute, useRouter} from "vue-router";
import {cancelReturn, getOrderById} from "../../api/api";
import {computed, onMounted, reactive, toRefs} from "vue";
import OrderItem from "./OrderItem";
import ShipDialog from "./Return/ShipDialog";
import {buttonText, statusList, returnStatusList, orderDelete} from "../../api/order";
import {Dialog, Toast} from "vant";
import lodash from "lodash";


export default {
    name: 'order_detail',
    components: {
        OrderItem,
        ShipDialog
    },
    setup() {
        const {query} = useRoute();
        const {push, back} = useRouter();
        const data = reactive({
            order: null,
            loading: false,
        });
        let id = query.order_id;

        const titleStatusText = {
            1: '订单未支付',
            2: '订单支付成功',
            3: '订单支付失败',
            4: '订单退货/退款中',
            5: '订单已发货',
            6: '订单已取消',
        };

        const infoStatusText = {
            1: '用户支付终止,或者未支付',
            2: '订单支付成功,等待发货',
            3: '订单支付失败,请查看扣款情况,联系客服或者重新支付',
            4: '用户申请退货/退款中.',
            5: '订单已发货',
            6: '用户超时未支付自动取消或主动取消',
        };

        const returnInfoText = {
            1: '申请退货/退款中,等待商家同意',
            2: '商家同意退货退款,等待买家将货物退回',
            3: '买家已将货物发回,请等待商家收到货物退款',
            4: '申请退款申请中,等待商家同意',
            5: '商家已同意退款',
            6: '退款已取消,商家拒绝退款或者退款终止',
            7: '申请换货/换款,等待商家同意',
            8: '商家同意换货/换款,等待买家发货',
            9: '商家同意换货/换款,买家已将货物发回',
        }

        const getOrderDetail = async () => {
            data.loading = true;
            let result = await getOrderById(query.order_id);
            data.loading = false;

            let item = result.data;
            console.log("item", item);
            data.order = {
                ...item,
                custom_info: JSON.parse(item.custom_info),
                snapshot: [].concat(JSON.parse(item.snapshot)),
            };
        }

        onMounted(() => {
            getOrderDetail();
        })

        const deleteOrder = () => {
            Dialog.confirm({
                title: '删除订单',
                message: '是否要删除订单',
            })
                .then(() => {
                    orderDelete(id);
                    Toast.success('订单删除成功.')
                    setTimeout(() => {
                        back();
                    }, 1500)
                })
                .catch(() => {
                    // on cancel
                });

        }
        const handleCancelReturn = () => {
            Dialog.confirm({
                title: '取消订单退货/退款',
                message: '是否要取消订单退货/退款',
                beforeClose: async (action) => {
                    if (action === 'confirm') {
                        let result = await cancelReturn({
                            order_id: id,
                        });
                        let errMsg = lodash.get(result, 'errMsg');
                        if (errMsg)
                            Toast.fail(errMsg);
                        else {
                            Toast.success(lodash.get(result, 'msg'));
                            getOrderDetail();
                        }
                        console.log("result", result);
                    }
                    return true;
                }
            })
                .then(async () => {

                })
                .catch(() => {
                    // on cancel
                });
        }
        const customerClick = (text) => {
            let {customer_phone, customer_wechat} = window._setting_;
            Dialog.alert({
                message: `
<div>当前客服不在线,请通过下方方式联系</div>
<div>${text}电话: <a href="tel:${customer_phone}">${customer_phone}</a></div>
<div>${text}微信: ${customer_wechat}</div>
`,
                allowHtml: true,
                theme: 'round-button',
            }).then(() => {
                // on close
            });
        }
        const toPay = () => {
            Toast.loading('获取支付信息...');
            window.location.href = `/api/pay?order_id=${id}`;
        }
        const returnOrder = () => {
            Toast.loading('订单信息,前往退款页面...');
            push({
                path: `/order/return`,
                query: {
                    order_id: id,
                }
            })
        }
        const refreshOrder = () => {
            getOrderDetail();
        }
        const checkLogistic = () => {
            let {logistic_number} = data.order;
            console.log("log",logistic_number);
            if (logistic_number) {
                window.location.href = `https://m.kuaidi100.com/app/query/?com=shunfeng&nu=${logistic_number}&coname=px&callbackurl=${window.location.href}`
            } else {
                Toast('未发货,请耐心等待');
            }
        }

        const showShipButton = computed(() => {
            let status = data.order.return_status;
            return [2, 8].includes(status);
        })
        const showComplaintButton = computed(() => {
            let status = data.order.status;
            return [2, 5].includes(status);
        })

        const handleComplaintClick = () => {
            push({
                path: '/complaint',
                query: {
                    order_id: id
                }
            })
        }

        return {
            ...toRefs(data),
            deleteOrder,
            toPay,
            returnOrder,
            handleCancelReturn,
            customerClick,
            refreshOrder,
            checkLogistic,
            handleComplaintClick,
            statusList,
            buttonText,
            titleStatusText,
            infoStatusText,
            returnStatusList,
            returnInfoText,
            showShipButton,
            showComplaintButton,

        }
    }
}
</script>

<style scoped lang="less">

.order_detail {
    padding-bottom: 130px;
}

.order-detail_footer {

}

.order_status {
    background-color: #FE4261;
    color: #fff;
    display: flex;

    justify-content: center;
    flex-direction: column;
    padding: 30px 20px;

    .status_title {
        font-size: 26px;
        padding-bottom: 15px;
    }

    .status_info {
        font-size: 18px;
    }
}

.order-detail_location {
    padding-top: 15px;

    .location_title {
        font-size: 18px;
        padding-bottom: 8px;

        strong {
            font-size: 26px;
        }
    }

    .location_label {
        font-size: 18px;
        line-height: 1.2;
        color: #333;
    }

    .van-contact-card {
        padding: 25px 16px;
    }
}

.order-detail_gird {
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px 0;
    background-color: #fff;
}

.order-detail_total {
    margin-top: 15px;
    background-color: #fff;
    display: flex;
    //justify-content: center;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;

    .total_status {
        flex: none;
        font-size: 26px;
    }

    .total_price {
        flex: none;
        margin-left: auto;
        display: flex;
        font-size: 18px;
        align-items: center;

        .count {
            color: #777;
        }

        .price {
            margin-left: 20px;
            color: #E54552;
            font-weight: bold;
            font-size: 23px;
        }

    }

}

.order-detail_footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #fff;
    display: flex;
    justify-content: flex-end;
    padding: 30px 20px;

    .van-button {
        margin-right: 15px;

        &:last-child {
            margin-right: 0;
        }
    }

}

</style>
