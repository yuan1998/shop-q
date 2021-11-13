import lodash from 'lodash';
import {database} from "./common";

let table = "order";
if (!database.tableExists(table)) {
    database.createTable(table, ["order_id"]);

    database.commit();
}


export const addOrder = (id) => {

    database.insert(table, {
        order_id: id,
    })
    database.commit();
}

export const orderList = (page = 1, pageSize = 15) => {
    return database.query(table, {}, pageSize, (page - 1) * pageSize, ["ID", "DESC"])
}

export const orderIdStr = () => {
    let orderIdList = orderList();
    console.log("orderIdList",orderIdList);
    return  lodash.map(orderIdList, 'order_id').join(',');
}
