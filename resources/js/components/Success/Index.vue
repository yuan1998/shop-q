<template>
    <div id="success">
        <van-empty
            class="custom-image"
            image="https://pic.imgdb.cn/item/61851b5e2ab3f51d916df2ec.png"
            description="支付成功"
        >
            <van-button @click="backOrder" round type="danger" class="bottom-button">
                返回订单列表
            </van-button>
        </van-empty>
    </div>
</template>

<script>
import {useRouter} from "vue-router";

export default {
    name: 'success',
    setup() {
        const router = useRouter()

        const backOrder = () => {
            router.push({
                path: '/order'
            });
        }
        return {
            backOrder
        }
    }
}
</script>

<style scoped>

</style>
