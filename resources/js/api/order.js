import lodash from 'lodash';
import {database} from "./common";

let table = "order";
if (!database.tableExists(table)) {
    database.createTable(table, ["order_id"]);

    database.commit();
}

export const existsOrder = (id) => {
    let exists = database.query(table, {
        order_id: id,
    });

    return !!exists.length;
}

export const addOrder = (id, commit = true) => {
    if (!existsOrder(id)) {
        database.insert(table, {
            order_id: id,
        })
        commit && database.commit();
    }
}

export const truncateOrder = () => {
    database.truncate(table);
    database.commit();
}

export const mergeOrder = (ids) => {
    for (let i = 0; i < ids.length; i++) {
        let id = ids[i];
        addOrder(id, false);
    }
    database.commit();
}

export const orderList = (page = 1, pageSize = 15) => {
    return database.query(table, {}, pageSize, (page - 1) * pageSize, ["ID", "DESC"])
}

export const orderIdStr = () => {
    let orderIdList = orderList();
    console.log("orderIdList", orderIdList);
    return lodash.map(orderIdList, 'order_id').join(',');
}

export const orderDelete = (id) => {
    if (!id) return;
    database.deleteRows(table, {order_id: id});
    database.commit();
}

export const buttonText = {
    1: '去支付',
    2: '退货/退款',
    3: '去支付',
    4: '退款中',
    5: '已发货',
    6: '订单已取消',
};

export const statusList = {
    1: '未支付',
    2: '支付成功',
    3: '支付失败',
    4: '退货/退款中',
    5: '已发货',
    6: '已取消',
};

export const returnStatusList = {
    1: '申请退货退款中',
    2: '退货退款同意-待发货',
    3: '退货退款同意-已发货',
    4: '申请退款',
    5: '同意退款',
    6: '取消退款',
    7: '换货/换款',
    8: '同意换货/换款-待发货',
    9: '同意换货/换款-已发货',
}
