<template>
    <div class="product_container">
        <div class="header">
            <van-image src="https://pic.imgdb.cn/item/619aefaa2ab3f51d9157501a.jpg"></van-image>
        </div>
        <van-tabs v-model:active="activeName" sticky>
            <van-tab title="精选" name="a">
                <van-swipe class="image_swiper"
                           :autoplay="3000"
                           v-if="banners && banners.length"
                           indicator-color="#262626"
                >
                    <van-swipe-item v-for="banner in banners"
                                    :key="banner.id"
                    >
                        <van-image
                            height="100%"
                            width="100%"
                            fit="cover"
                            :src="`/storage/${banner.image}`"
                            @click="handleClickSwiper(banner)"
                        />
                    </van-swipe-item>
                </van-swipe>

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
        </van-tabs>
    </div>
</template>
<script>
import {onMounted, reactive, ref, toRefs} from "vue";
import {getBannerList, getProductList} from "../../api/api";
import {Toast} from 'vant'
import lodash from 'lodash'
import ProductItem from '../Product/Item'

const listMethod = async (page) => {
    let result = await getProductList(page);
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
    setup() {
        let data = reactive({
            loading: false,
            finished: false,
            list: [],
            banners: [],
            currentPage: null,
            activeName: 'a'
        })

        onMounted(async () => {
            await getBanner();
        })

        const getBanner = async () => {
            let result = await getBannerList();
            data.banners = result.data;

        }

        const onLoad = async () => {
            let d = await listMethod(data.currentPage ? data.currentPage + 1 : 1);
            data.loading = false;
            data.list = data.list.concat(d.data);
            data.currentPage = d.current_page;
            if (d.current_page >= d.last_page) {
                data.finished = true;
            }
        }

        const handleClickSwiper = (banner) => {
            window.location.href = banner.url;
        }

        return {
            ...toRefs(data),
            onLoad,
            handleClickSwiper,
        };
    },
}
</script>
<style lang="less">

.product_container {

    .test_1 {
        padding: 20px;
    }

    .image_swiper {
        margin-top: 15px;
        height: 60vw;
        max-height: 450px;
    }
}


</style>
