<template>
    <div id="success">
        <van-empty
            class="custom-image"
            image="error"
            description="支付已取消或支付失败"
        >
            <van-button @click="backHome" round type="danger" class="bottom-button">返回订单列表</van-button>

        </van-empty>

    </div>
</template>

<script>

import {useRouter} from "vue-router";

export default {
    name: 'success',
    setup() {
        const router = useRouter()
        const backHome = () => {
            router.push({
                path: '/'
            })
        }
        return {
            backHome
        }
    }
}
</script>

<style scoped>

</style>
