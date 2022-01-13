<template>
    <div class="pla"></div>
    <van-tabbar route active-color="#ee0a24" inactive-color="#000">
        <van-tabbar-item replace to="/"  icon="home-o">首页</van-tabbar-item>
        <van-tabbar-item to="/cart"  icon="cart-o">购物车</van-tabbar-item>
        <van-tabbar-item replace to="/order"  icon="orders-o">订单</van-tabbar-item>
    </van-tabbar>
</template>
<script setup>

</script>
<style scoped lang="less">
.pla {
    height: 50px;
}

</style>
