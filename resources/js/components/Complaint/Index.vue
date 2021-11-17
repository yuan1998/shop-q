<template>
    <div class="complaint_index">
        <van-nav-bar fixed placeholder left-arrow title="投诉订单" @click-left="$router.back()"/>
        <div class="">
            <van-cell-group style="margin-top: 15px;">
                <van-field v-model="formData.phone" required placeholder="联系电话"/>
                <van-field v-model="formData.wechat" placeholder="微信(选填)"/>

            </van-cell-group>
            <van-cell-group style="margin-top: 15px;">

                <van-field v-model="formData.comment"
                           type="textarea"
                           required
                           placeholder="投诉信息">
                </van-field>
            </van-cell-group>


            <div class="submit-button">
                <van-button color="#E8445B"
                            @click="mapToStoreComplaint"
                            block>
                    <van-icon name="plus"/>
                    提交投诉
                </van-button>
            </div>
        </div>
    </div>
</template>

<script>
import {Toast} from 'vant';
import {useRoute, useRouter} from "vue-router";
import {storeComplaint} from "../../api/api";
import {reactive, toRefs} from "vue";

export default {
    name: 'complaint_index',
    setup() {
        const {query} = useRoute();
        const router = useRouter();
        const data = reactive({
            formData: {
                phone: '',
                wechat: '',
                comment: '',
            }
        });
        let orderId = query?.order_id;

        const validateFormData = () => {
            const {phone, comment} = data.formData;

            if (!phone || !/^[1][345789][0-9]{9}$/.test(phone))
                return '请输入联系电话';

            if (!comment)
                return '请输入投诉信息';

        }

        const mapToStoreComplaint = async () => {
            let msg = validateFormData();
            if (msg) {
                Toast.fail(msg);
                return;
            }

            let result = await storeComplaint({
                ...data.formData,
                order_id: orderId,
            });

            if (result.status === 0) {
                Toast.success(result.msg);
                setTimeout(() => {
                    router.back();
                },1500)
            }
        }

        return {
            order_id: orderId,
            ...toRefs(data),
            mapToStoreComplaint,
        }
    }
}
</script>

<style scoped lang="less">
.submit-button {
    position: fixed;
    padding: 20px;
    bottom: 0;
    left: 0;
    right: 0;
}

</style>
