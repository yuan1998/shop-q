import AMapLoader from '@amap/amap-jsapi-loader'

export const AMapKey_H5 = '6508f88b1cc036289401a18ac8000141';

let AMap = null

const initAMap = async () => {
    AMap = await AMapLoader.load({
        "key": AMapKey_H5,
        "version": '2.0',
        "plugins": ['AMap.PlaceSearch', 'AMap.Geolocation']
    });
}

export const getAMapIns = async () => {
    if (!AMap)
        await initAMap();
    console.log("AMap", AMap);

    return AMap;
}

export const searchNear = async () => {
    let map = await getAMapIns();

    let placeSearch = new map.PlaceSearch({
        // city: '', // 兴趣点城市
        citylimit: true, // 是否强制在设置的城市内搜索，默认false
        // type: '', // 兴趣点类别，用‘|’分隔，默认：'餐饮服务|商务住宅|生活服务'
        pageSize: 20, // 每页条数，默认10，范围1-50
        pageIndex: 1, // 页码
        extensions: 'all', // 默认base，返回基本地址信息；all：返回详细信息
        // map: map, // 地图实例，可选
        // panel: 'panel', // 结果列表的id容器，可选
        // autoFitView: true, // 是否自动调整地图视野到marker点都处于可见范围
    })

    let keywords = '', // 关键字
        position = [116.857461, 38.310582], // 中心点经纬度
        radius = 2000; // 搜索半径 0-50000
    placeSearch.searchNearBy(keywords, position, radius, function (status, result) {
        console.log(result)
    })
}

export const getLocation = async () => {
    let map = await getAMapIns();
    let geolocation = new map.Geolocation({
        enableHighAccuracy: true, // 是否获取高精度定位，可能影响效率，默认false
        timeout: 10000, // 定位超时时间，ms
        needAddress: true, // 是否需要将定位结果进行逆地理编码操作
        extensions: 'all', // 是否需要详细的你地理编码信息，默认'base'
    })

    //

    return new Promise((resolve, reject) => {

        // 获取精确位置
        geolocation.getCurrentPosition(function (status, result) {
            if (status === 'complete') {
                resolve(result);
            } else {
                reject(result);
            }
        })

        // // 获取城市信息
        // geolocation.getCityInfo(function (status, result) {
        //     if (status === 'complete') {
        //         resolve(result);
        //     } else {
        //         reject(result);
        //     }
        //     // console.log(status);
        //     // console.log(result);
        // })
    })
}

