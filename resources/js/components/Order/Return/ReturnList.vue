<template>
    <div class="return-list">
        <van-nav-bar fixed placeholder left-arrow title="申请退货" @click-left="$router.back()"/>
        <van-radio-group v-model="checked" style="margin-top: 15px;">
            <van-cell-group>
                <van-cell size="large"
                          is-link
                          value-class="van-concat-card__value"
                          class="van-cell--center van-cell--clickable van-location-card--add"
                          clickable @click="checked = '1'"
                >
                    <template #icon>
                        <van-icon name="refund-o" color="#EE6765" size="35" style="margin-right: 20px;"/>
                    </template>
                    <template #title>
                        <div class="cell-title">
                            申请退货退款
                        </div>
                    </template>
                    <template #label>
                        <div class="cell-label">
                            申请退货退款,将货物退回
                        </div>
                    </template>
                    <template #right-icon>
                        <van-radio checked-color="#EE6765" name="1"/>
                    </template>
                </van-cell>
                <van-cell size="large"
                          is-link
                          value-class="van-concat-card__value"
                          class="van-cell--center van-cell--clickable van-location-card--add"
                          clickable @click="checked = '4'"
                >
                    <template #icon>
                        <van-icon name="cash-back-record" color="#EE6765" size="35" style="margin-right: 20px;"/>
                    </template>
                    <template #title>
                        <div class="cell-title">
                            仅退款
                        </div>
                    </template>
                    <template #label>
                        <div class="cell-label">
                            申请退货退款,将货物退回
                        </div>
                    </template>
                    <template #right-icon>
                        <van-radio checked-color="#EE6765" name="4"/>
                    </template>
                </van-cell>
                <van-cell size="large"
                          is-link
                          value-class="van-concat-card__value"
                          class="van-cell--center van-cell--clickable van-location-card--add"
                          clickable @click="checked = '7'"
                >
                    <template #icon>
                        <van-icon name="exchange" color="#EE6765" size="35" style="margin-right: 20px;"/>
                    </template>
                    <template #title>
                        <div class="cell-title">
                            换货/换款
                        </div>
                    </template>
                    <template #label>
                        <div class="cell-label">
                            申请仅退款
                        </div>
                    </template>
                    <template #right-icon>
                        <van-radio checked-color="#EE6765" name="7"/>
                    </template>
                </van-cell>
            </van-cell-group>
        </van-radio-group>
        <template v-if="checked">
            <div class="return-list_reason">
                <van-field
                    size="large"
                    v-model="reason"
                    rows="3"
                    autosize
                    label="退款理由"
                    type="textarea"
                    placeholder="请输入退款理由"
                />
            </div>
            <div class="return-list_footer">
                <van-button @click="handleReturn" size="large" color="#EE6765" block>提交申请</van-button>
            </div>
        </template>

    </div>
</template>

<script>
import lodash from 'lodash';
import {useRoute, useRouter} from "vue-router";
import {reactive, toRefs} from "vue";
import {requestReturn} from "../../../api/api";
import {Toast} from 'vant';

export default {
    name: 'return-list',
    setup() {
        const router = useRouter();
        const {query} = useRoute();
        const data = reactive({
            checked: '',
            reason: '',
            loading: false,
        });

        const handleReturn = async () => {
            let returnReason = data.reason;
            if (!returnReason) {
                Toast.fail('请输入退款理由.');
                return;
            }

            Toast.loading('发送申请中');
            let result = await requestReturn({
                return_status: data.checked,
                return_reason: returnReason,
                order_id: query.order_id
            });
            let errMsg = lodash.get(result,'errMsg');
            if (errMsg)
                Toast.fail(errMsg);
            else {
                Toast.success(lodash.get(result,'msg'));
                router.back();
            }
            console.log("result",result);
        }


        return {
            ...toRefs(data),
            handleReturn,
        }
    }
}
</script>

<style scoped lang="less">
.return-list {
    padding-bottom: 100px;

    .cell-title {
        font-size: 21px;
        margin-bottom: 8px;
    }

    .cell-label {
        font-size: 16px;
    }

    .return-list_reason {
        margin-top: 15px;
    }


    .return-list_footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
    }

}


</style>
