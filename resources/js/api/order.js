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
