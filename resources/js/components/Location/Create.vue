<template>
    <div class="location-create">
        <van-nav-bar fixed placeholder left-arrow title="新建收货地址" @click-left="$router.back()"/>
        <div class="">
            <van-cell-group style="margin-top: 15px;">
                <van-field v-model="form.name" placeholder="收货人"/>
                <van-field v-model="form.phone" placeholder="手机电话"/>
                <van-field v-model="areaText"
                           readonly
                           @click="show = true;"
                           placeholder="选择地区"
                >
                    <template #right-icon>
                        <van-icon name="arrow"/>
                    </template>
                </van-field>
                <van-field v-model="form.address" type="textarea" placeholder="详细地址: 如街道 楼道号等">
                    <template #right-icon>
                        <div class="address_icon">
                            <van-icon color="#C4535C"
                                      @click="handleGetLocation"
                                      name="location-o"
                            />
                            <div>
                                定位
                            </div>
                        </div>
                    </template>
                </van-field>
            </van-cell-group>

            <van-cell-group style="margin-top: 15px;">
                <van-cell title="地址标签">
                    <template #value>
                        <div class="tag_actions">
                            <div v-for="item in staticData.tags"
                                 :key="item"
                                 :class="`tag ${form.tag === item ? 'active' : ''}`"
                                 @click="handleClickTag(item)"
                            >
                                {{ item }}
                            </div>
                        </div>

                    </template>

                </van-cell>
                <van-cell center title="设置为默认地址">
                    <template #right-icon>
                        <van-switch v-model="form.default"
                                    active-color="#E8445B"
                                    size="24"/>
                    </template>
                </van-cell>
            </van-cell-group>

            <div class="submit-button">
                <van-button color="#E8445B"
                            @click="onAdd"
                            block>
                    <van-icon name="plus"/>
                    {{ editID ? "修改地址" : "新建地址" }}
                </van-button>
            </div>
        </div>

        <van-action-sheet v-model:show="locationShow"
                          closeable
                          cancel-text="取消"
                          close-on-click-action
        >
            <div class="location_action_sheet">
                <van-skeleton title :row="5" :loading="locationLoading">
                    <div>
                        <van-cell v-for="item in locationInfo.pois"
                                  :key="item.id"
                                  :title="item.name"
                                  :label="item.address"
                                  @click="inputSearchLocation(item)"
                        />

                    </div>
                </van-skeleton>
            </div>

        </van-action-sheet>
        <van-action-sheet v-model:show="show"
                          closeable
        >
            <van-area title="选择地区"
                      :area-list="areaList"
                      :columns-placeholder="['请选择', '请选择', '请选择']"
                      @confirm="confirmArea"
                      @cancel="cancelArea"
            />
        </van-action-sheet>
    </div>
</template>

<script>
import {
    addLocationData,
    editLocationData,
    getLocationData,
    searchLocation,
    setChosenLocationId
} from "../../api/location";
import {computed, onMounted, reactive, toRef, toRefs} from "vue";
import {Toast} from 'vant'
import {areaList} from '@vant/area-data';
import {getLocation} from "../../api/amap";
import {useRoute, useRouter} from "vue-router";
import lodash from 'lodash';

export default {
    name: 'location-create',
    setup() {
        const router = useRouter();
        const route = useRoute();
        let editID = route.query.id;
        let edit = lodash.get(searchLocation({
            ID: editID
        }, 1), '0')


        let staticData = {
            tags: ['家', '公司', '学校']
        };
        let data = reactive({
            locations: getLocationData(),
            chosenAddressId: null,
            form: edit || {
                name: '',
                phone: '',
                area: [],
                address: '',
                tag: '',
                default: false,
                detail: '',
            },
            text: '',
            show: false,
            locationShow: false,
            locationLoading: false,
            locationInfo: null,
        });

        const validate = () => {
            let {name, phone, address} = data.form;
            if (!name)
                return '请输入收货人';
            if (!phone || !/^[1][345789][0-9]{9}$/.test(phone))
                return '请输入正确的收货人电话';
            if (!areaText.value)
                return '请选择地区';
            if (!address)
                return '请输入详细地址';
        }
        const onAdd = () => {
            let msg = validate();
            if (msg) {
                Toast(msg);
                return;
            }
            data.form.detail = areaText.value + data.form.address;
            let id = editID ? editLocationData(data.form, editID) : addLocationData(data.form);

            Toast(`${editID ? '修改' : '创建'}地址成功`);
            let {action} = route.query;
            if (action === 'chose') {
                setChosenLocationId(id);
            }
            router.back();
        };
        const onEdit = (item, index) => Toast('编辑地址:' + index);
        const areaText = computed(() => {
            return data.form.area?.map((item) => {
                return item.name;
            }).join(' ');
        })
        const cancelArea = () => {
            data.show = false;
        }

        const confirmArea = (result) => {
            data.show = false;
            data.form.area = result?.filter((item) => {
                return item && item.name;
            });
            console.log("result", result);
        }

        const handleGetLocation = async () => {
            data.locationShow = true;
            data.locationLoading = true;
            data.locationInfo = await getLocation();
            data.locationLoading = false;
        }
        const inputSearchLocation = async (item) => {
            data.form.address = item.address + item.name;
            data.locationShow = false;
        }

        const handleClickTag = (item) => {
            console.log("item", item);
            data.form.tag = item;
        }

        return {
            ...toRefs(data),
            staticData,
            areaList,
            editID,
            handleClickTag,
            onAdd,
            onEdit,
            confirmArea,
            cancelArea,
            handleGetLocation,
            inputSearchLocation,
            areaText,
        }
    }
}
</script>

<style scoped lang="less">

.location_action_sheet {
    height: 70vh;
}

.address_icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    border-left: 1px solid #E8E8E8;
    padding-left: 20px;
}

.submit-button {
    position: fixed;
    padding: 20px;
    bottom: 0;
    left: 0;
    right: 0;
}

.tag_actions {
    display: flex;
    align-items: center;
    justify-content: space-around;

    .tag {
        background-color: #F2F2F2;
        color: #757575;
        padding: 3px 7px;

        &.active {
            background-color: #F7E7E8;
            color: #C9636C;
        }
    }
}

</style>
