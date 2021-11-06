<template>
    <van-action-sheet v-model:show="show"
                      closeable
                      @close="$emit('update:show',false)"
    >
        <div class="action-content">
            <div class="action-content_header">
                <div class="price_text">
                    <span class="syb">¥</span>
                    {{ product.price }}
                </div>
                <div class="action_text">
                    剩余 21 件
                </div>
                <div class="action_text">
                    {{ unSelectField ? `请选择 ${unSelectField}` : `已选择  ${selectField}` }}
                </div>
                <van-divider/>
            </div>
            <div class="action-content_step">
                <div class="action-content_step_sku_item" :key="key" v-for="(sku,key) in product.skus">
                    <div class="sku_name">
                        {{ key }}
                    </div>
                    <div class="sku_values">
                        <div @click="selectSku(key,item.title)"
                             v-for="(item,index) in sku"
                             :key="index"

                             class="sku_value" :class="select[key] === item.title ? 'selected' : ''"
                        >
                            <div class="sku_value-image" v-if="item.value">
                                <div class="sku_value-image-preview" @click="imagePreview(`/storage/${item.value}`)">
                                    <van-icon size="17" name="expand-o" />
                                </div>
                                <img class="mc-img" :src="`/storage/${item.value}`" alt="">
                            </div>
                            <div class="sku_value-text">
                                {{ item.title }}
                            </div>
                        </div>
                    </div>
                    <van-divider/>

                </div>
                <van-field name="stepper" label="购买数量" input-align="right">
                    <template #input>
                        <van-stepper v-model="count"/>
                    </template>
                </van-field>
            </div>
            <div class="action-content_footer">
                <van-divider/>
                <van-button @click="handleSubmit" size="large" round type="danger">立即购买</van-button>
            </div>
        </div>
    </van-action-sheet>
</template>

<script>

import {onMounted, reactive, toRefs, computed} from "vue";
import {ImagePreview, Toast} from "vant";

export default {
    name: 'sku',
    props: ['product', 'show'],
    emits: ['update:show', 'buy'],

    setup(props, {emit}) {
        const {product} = props;
        const data = reactive({
            select: {},
            count: 1,
        });

        onMounted(() => {
            Object.keys(product.skus).forEach((key) => {
                data.select[key] = '';
            })
            console.log("data.select", data.select);
        });

        const selectSku = (key, value) => {
            data.select[key] = value;
        }

        const unSelectField = computed(() => {
            let arr = [];
            Object.keys(data.select).forEach((key) => {
                if (!data.select[key])
                    arr.push(key);
            });
            return arr.join(' ')
        })


        const selectField = computed(() => {
            let arr = [];
            Object.keys(data.select).forEach((key) => {
                arr.push(data.select[key]);
            });
            return arr.join(' ')
        })

        const imagePreview = (url) => {
            ImagePreview([
                url,
            ]);
        }
        const onCancel = () => {

        };
        const handleSubmit = () => {
            let value = unSelectField.value;
            if (value) {
                Toast(`请选择 ${value}`);
                return;
            }

            emit('buy', data);
        }


        return {
            selectSku,
            imagePreview,
            onCancel,
            unSelectField,
            selectField,
            handleSubmit,
            ...toRefs(data)
        }
    }
}
</script>

<style scoped lang="less">

.action-content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    height: 60vh;

    .action-content_footer,
    .action-content_header {
        flex: none;
    }

    .action-content_step {
        flex: auto;
        overflow: scroll;
    }


    .action_text {
        color: #999;
        font-size: 14px;
    }


    .sku_values {
        display: flex;
        flex-wrap: wrap;
    }

    .sku_name {
        padding-bottom: 12px;
        font-size: 16px;
    }

    .sku_value-image {
        max-width: 100px;
        min-width: 80px;
        min-height: 80px;
        display: inline-block;
    }

    .sku_value-image-preview {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 3;
        width: 18px;
        height: 18px;
        color: #fff;
        line-height: 18px;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.4);
        border-bottom-left-radius: 4px;
    }

    .sku_value {
        text-align: center;
        flex: none;
        margin-bottom: 15px;
        margin-right: 15px;

        background-color: #F7F8FA;

        .sku_value-text {
            padding: 8px 12px;
            color: #333;
        }

        &.selected {
            background-color: #FDE7EA;
            color: #EE1131;
        }
    }
}

</style>
