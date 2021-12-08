<template>
    <van-cell>
        <template #title>
            <div class="reply-title">
                <van-image :src="thumbUrl"
                           width="35"
                           height="35"
                           fit="cover"
                           round
                           style="margin-right: 15px;"
                />
                {{ username }}
            </div>
        </template>
        <template #label>
            <div class="reply-comment">
                {{ reply.comment }}
            </div>
            <div class="reply-images" v-if="images">
                <van-image v-for="(image,index) in images"
                           @click="handleImageClick(index)"
                           class="reply-image"
                           width="60"
                           height="60"
                           fit="cover"
                           :key="index"
                           :src="image"
                />
            </div>
        </template>
    </van-cell>
</template>

<script>

import {computed} from "vue";
import {ImagePreview} from "vant";

export default {
    name: 'reply-item',
    props: ['reply'],
    setup(props) {
        const {reply} = props;

        const thumbUrl = computed(() => {
            return /http(s)?:\/\//.test(reply.thumb) ? reply.thumb : `/storage/${reply.thumb}`;
        })

        const username = computed(() => {
            let un = reply.username;
            return `${un.substring(0, 1)}**${un.substring(un.length - 1, un.length)}`;
        })
        const images = computed(() => {
            let images = reply?.images;

            return images ? JSON.parse(images) : null;
        })

        const handleImageClick = (index) => {
            if (images.value) {
                ImagePreview({
                    images: images.value,
                    startPosition: index,
                    closeable: true,
                });
            }
        }

        return {
            reply,
            thumbUrl,
            username,
            images,
            handleImageClick
        }
    }
}
</script>

<style scoped lang="less">
.reply-title {
    font-size: 20px;
    display: flex;
    align-items: center;
    color: #888;

}

.reply-comment {
    font-size: 18px;
    color: #555;
    margin-top: 15px;
    margin-bottom: 15px;
}

.reply-image {
    border: 1px solid #999;
    margin-right: 10px;
    padding: 3px;
    border-radius: 3px;
}

</style>
