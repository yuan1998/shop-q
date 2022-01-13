<template>
  <van-action-sheet v-model:show="show"
                    closeable
                    @close="hideSku"
  >
    <div class="action-content">
      <div class="action-content_header">
        <div class="flex-container">
          <div class="header-content_image">
            <img @click="imagePreview(photo)" :src="photo" alt="" class="mc-img">
          </div>
          <div class="header_content">
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
          </div>
        </div>
        <van-divider/>

      </div>
      <div class="action-content_step">
        <div class="action-content_step_sku_item" :key="key" v-for="(sku,key) in skuArr">
          <div class="sku_name">
            {{ sku['name'] }}
          </div>
          <div class="sku_values">
            <div @click="selectSku(sku['name'],item)"
                 v-for="(item,index) in sku['data']"
                 :key="index"
                 class="sku_value" :class="select[sku['name']] === item.title ? 'selected' : ''"
            >
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
        <van-button
            v-if="action === 'buy'"
            @click="handleSubmit"
            size="large"
            round
            color="linear-gradient(to right, #ff6034, #ee0a24)"
        >
          立即购买
        </van-button>
        <van-button
            v-else
            @click="handleAddToCart"
            size="large"
            round
            type="warning"
        >
          加入购物车
        </van-button>
      </div>
    </div>
  </van-action-sheet>
</template>

<script>

import {onMounted, reactive, toRefs, computed, inject} from "vue";
import {ImagePreview, Toast} from "vant";

export default {
  name: 'sku',
  props: ['product', 'show', 'action'],
  setup(props) {
    const {product, action} = props;
    const data = reactive({
      select: {},
      count: 1,
      selectPhoto: null,
      skuArr: [],
      action,
    });
    const {buyProduct, cartProduct, hideSku} = inject('product')

    onMounted(() => {
      let sku = JSON.parse(product.attribute.skus);
      data.skuArr = sku?.sort(function (a, b) {
        return b.order - a.order;
      })?.map((item) => {
        return {
          ...item,
          data: product.skus[item.name],
        }
      });

      sku.forEach((item) => {
        data.select[item['name']] = '';
      })
    });

    const selectSku = (key, item) => {
      data.select[key] = item.title;

      if (item.value) {
        data.selectPhoto = `/storage/${item.value}`;
      }

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

    const photo = computed(() => {
      if (data.selectPhoto) {
        return data.selectPhoto;
      }
      let value = product.images[0].value;

      return `/storage/${value}`;
    })

    const imagePreview = (url) => {
      ImagePreview([
        url,
      ]);
    }
    const onCancel = () => {

    };
    const validateSelect = () => {
      let value = unSelectField.value;
      if (value) {
        Toast(`请选择 ${value}`);
      }
      return !value;
    }
    const handleSubmit = () => {
      if (!validateSelect())
        return;

      buyProduct(data);
      // emit('buy', data);
    }
    const handleAddToCart = () => {
      if (!validateSelect())
        return;
      cartProduct(data);
    }


    return {
      selectSku,
      imagePreview,
      onCancel,
      photo,
      unSelectField,
      selectField,
      handleSubmit,
      handleAddToCart,
      hideSku,
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
  height: 70vh;

  .flex-container {
    display: flex;

    .header-content_image {
      width: 80px;
      height: 80px;
      flex: none;
    }

    .header_content {
      flex: auto;
      padding-left: 20px;
    }
  }

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
      background-color: #FDE7EA !important;

      .sku_value-text {
        color: #CE758B !important;
      }
    }
  }
}

</style>
