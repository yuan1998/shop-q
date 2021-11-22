<template>
    <div class="product_container">
        <div class="header">
            <van-image src="https://pic.imgdb.cn/item/619aefaa2ab3f51d9157501a.jpg"></van-image>
        </div>
        <van-tabs v-model:active="activeName" sticky>
            <van-tab title="精选" name="a">
                <van-list
                    v-model:loading="loading"
                    :finished="finished"
                    finished-text="没有更多了"
                    @load="onLoad"
                >
                    <van-row gutter="20" class="test_1">
                        <van-col span="12" v-for="(item ,i) in list">
                            <ProductItem :data="item"/>
                        </van-col>
                    </van-row>
                </van-list>

            </van-tab>
            <!--            <van-tab title="商品" name="b">内容 2</van-tab>-->
        </van-tabs>
    </div>
</template>
<script>
import {reactive, ref, toRefs} from "vue";
import {getProductList} from "../../api/api";
import lodash from 'lodash'
import ProductItem from '../Product/Item'


const listMethod = async () => {
    let result = await getProductList();
    let data = result.data.data.map((item) => {
        let images = JSON.parse(item.images);
        item.image = lodash.get(images, '0.value');
        return item;
    })
    return {
        data,
        last_page: result.data.last_page,
        current_page: result.data.current_page,
    }
}


export default {
    components: {
        ProductItem
    },
    mounted() {
        // this.cs();
    },
    setup() {
        let data = reactive({
            loading: false,
            finished: false,
            list: [],
        })


        const onLoad = async () => {
            let d = await listMethod();
            data.loading = false;
            console.log("",);
            data.list = data.list.concat(d.data);

            if (d.current_page >= d.last_page) {
                data.finished = true;
            }

        }

        const activeName = ref('a');
        return {
            ...toRefs(data),
            onLoad,
            activeName
        };
    },
}
</script>
<style lang="less">

.product_container {

    .test_1 {
        padding: 20px;
    }

}


</style>
