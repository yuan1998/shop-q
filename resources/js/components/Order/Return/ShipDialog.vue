<template>
    <van-button type="default" @click="show=true;">
        退回货物
    </van-button>
    <van-dialog v-model:show="show"
                title="退回货物"
                show-cancel-button
                :before-close="test"
                @confirm="shipReturnProduct">
        <van-field
            size="large"
            v-model="logistics"
            rows="3"
            autosize
            type="textarea"
            placeholder="请输入退货单号"
        />
    </van-dialog>
</template>

<script>

import {reactive, toRefs} from "vue";
import {shipReturn} from "../../../api/api";
import lodash from "lodash";
import {Toast} from "vant";

export default {
    name: 'return-ship-dialog',
    props: ['order_id', 'status'],
    emits: ['refresh'],
    setup(props,{emit}) {
        const {order_id, status} = props;
        const data = reactive({
            show: false,
            logistics: ''
        });

        const shipReturnProduct = () => {
            console.log("123", 123);
            data.show = true;
        }
        const test = async (action) => {
            if (action === 'confirm') {
                let result = await shipReturn({
                    order_id,
                    logistics: data.logistics,
                    return_status: status == 2 ? 3 : 9,
                });
                let errMsg = lodash.get(result, 'errMsg');
                if (errMsg)
                    Toast.fail(errMsg);
                else {
                    Toast.success(lodash.get(result, 'msg'));
                    emit('refresh');
                }
            }

            return true;

            return new Promise((resolve) => {
                setTimeout(() => {
                    if (action === 'confirm') {
                        resolve(true);
                    } else {
                        // 拦截取消操作
                        resolve(false);
                    }
                }, 1000);
            });

        }

        return {
            ...toRefs(data),
            shipReturnProduct,
            test,
        }
    }
}
</script>

<style scoped lang="less">

</style>
