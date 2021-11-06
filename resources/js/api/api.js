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

export const getProductList = async () => {
    let result = await axios.get(BASE_URL + 'api/product/list')

    return result.data;
}

export const storeOrder = async (data) => {
    let result = await axios.post(BASE_URL + 'api/order/store', data);
    return result.data;
}
