import axios from 'axios';

const BASE_URL = '/';

export const getProductDetail = async (id) => {
    let result = await axios.get(BASE_URL + 'api/product/detail', {
        params: {
            id,
        }
    })

    return result.data;
}

export const getSetting = async () => {
    let result = await axios.get(BASE_URL + 'api/setting/')
    return result.data;
}

export const getProductList = async (page) => {
    let result = await axios.get(BASE_URL + 'api/product/list', {
        params: {
            page
        }
    })

    return result.data;
}

export const getOrderList = async (id, page) => {
    let result = await axios.get(BASE_URL + 'api/order/list', {
        params: {
            order_id: id,
            page,
        }
    })

    return result.data;
}

export const getBannerList = async (count = 5) => {
    let result = await axios.get(BASE_URL + 'api/banner/list', {
        params: {
            count,
        }
    })

    return result.data;
}


export const searchOrderByPhone = async (phone) => {
    let result = await axios.get(BASE_URL + 'api/order/searchByPhone', {
        params: {
            phone,
        }
    })

    return result.data;
}

export const storeOrder = async (data) => {
    let result = await axios.post(BASE_URL + 'api/order/store', data);
    return result.data;
}

export const outPayOrder = async (id) => {
    let result = await axios.post(BASE_URL + 'api/order/outPay', {
        order_id: id
    });
    return result.data;
}

export const getOrderById = async (id) => {
    let result = await axios.get(BASE_URL + 'api/order/getById', {
        params: {
            order_id: id
        }
    });
    return result.data;
}

export const requestReturn = async (data) => {
    let result = await axios.post(BASE_URL + 'api/order/return/request', data);
    return result.data;
}

export const shipReturn = async (data) => {
    let result = await axios.post(BASE_URL + 'api/order/return/shipReturn', data);
    return result.data;
}

export const cancelReturn = async (data) => {
    let result = await axios.post(BASE_URL + 'api/order/return/cancel', data);
    return result.data;
}


export const storeComplaint = async (data) => {
    let result = await axios.post(BASE_URL + 'api/complaint/store', data);
    return result.data;
}
