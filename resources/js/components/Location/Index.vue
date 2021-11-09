<template>
    <div class="location-index">
        <van-nav-bar fixed placeholder left-arrow title="收货地址" @click-left="$router.back()"/>
        <van-address-list
            v-model="chosenAddressId"
            :list="locations"
            default-tag-text="默认"
            @add="onAdd"
            @edit="onEdit"
            @select="onSelect"
        />
    </div>
</template>

<script>
import {getChosenLocation, getLocationData, setChosenLocationId} from "../../api/location";
import {reactive, toRef, toRefs} from "vue";
import {Toast} from 'vant'
import {useRouter} from "vue-router";

export default {
    name: 'location-index',
    setup() {
        let router = useRouter();
        let chose = getChosenLocation();
        console.log("chose", chose);

        let data = reactive({
            locations: getLocationData()?.map((item) => {
                return {
                    ...item,
                    id: item.ID,
                    tel: item.phone,
                    address: item.detail,
                    isDefault: item.default,
                }
            }),
            chosenAddressId: chose?.ID,
        });

        const onAdd = () => {
            router.push({
                path: '/location/create',
                query: {
                    action: 'chose'
                }
            })
        };
        const onEdit = (item, index) => {
            router.push({
                path: '/location/create',
                query: {
                    action: 'chose',
                    id: item.id
                }
            })
        };
        const onSelect = (item) => {
            setChosenLocationId(item.id);
            router.back();
        }

        return {
            ...toRefs(data),
            onAdd,
            onEdit,
            onSelect,
        }
    }
}
</script>

<style scoped>

</style>
