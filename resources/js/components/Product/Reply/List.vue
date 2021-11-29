<template>
    <div class="reply-list">
        <van-nav-bar fixed placeholder left-arrow title="全部评论" @click-left="$router.back()" />
        <van-skeleton :row="20" :loading="!list?.length && listLoading">
            <van-list v-model:loading="listLoading"
                      :finished="finished"
                      finished-text="没有更多了"
                      @load="getReplies">
                <Item v-for="reply in list"
                      :key="reply.id"
                      :reply="reply"
                />
            </van-list>
        </van-skeleton>
    </div>
</template>

<script>

import {useRoute} from "vue-router";
import {reactive, toRefs} from "vue";
import {getProductRepliesList} from "../../../api/api";
import Item from "./Item";

export default {
    name: 'reply-list',
    components: {
        Item
    },
    setup() {
        const {query} = useRoute();
        const data = reactive({
            page: 0,
            finished: false,
            firstLoading: true,
            listLoading: false,
            list: [],
        });
        const id = query.id;
        console.log("id",id);

        const getReplies = async (page) => {
            page = page || !data.page ? 1 : data.page + 1;

            console.log("page",page);
            data.listLoading = true;
            let result = await getProductRepliesList(page, id);
            let d = result.data;
            console.log("d",d);

            data.listLoading = false;
            data.list = data.list.concat(d?.data);
            data.page = d.current_page;
            if (d.current_page >= d.last_page) {
                data.finished = true;
            }
        }


        return {
            ...toRefs(data),
            getReplies,
        }
    }
}
</script>

<style scoped lang="less">

</style>
