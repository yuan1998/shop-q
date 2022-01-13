import {database} from "./common";

let table = "cart";
if (!database.tableExists(table)) {
    database.createTable(table, [
        'sku',
        'count',
        'product_id',
        'image',
        'title',
        'price',
        'add_date'
    ]);
    database.commit();
}

export const existsProduct = (id, sku) => {
    let exists = database.query(table, {
        product_id: id,
        sku,
    });

    return !!exists.length;
}

export const addProduct = (data, commit = true) => {
    if (!existsProduct(data.product_id, data.sku)) {
        database.insert(table, {
            ...data,
            add_date : new Date().getTime()
        })
        commit && database.commit();
    } else {
        cartProductCountAdd(data, data.count || 1, commit);
    }
}

export const truncateCart = () => {
    database.truncate(table);
    database.commit();
}

export const cartList = () => {
    return database.query(table, null, null, null, [["add_date", "DESC"]])
}

export const cartProductCountAdd = (data, count = 1, commit = true) => {
    let product_id = data.product_id;
    let sku = data.sku;
    if (!product_id) return;

    database.update(table, {
            product_id,
            sku,
        },
        function (row) { // update function
            row.count += count;
            row.add_date = new Date().getTime();
            return row;
        }
    );
    commit && database.commit();
}

export const cartDelete = (id) => {
    id = [].concat(id);
    if (!id.length) return;
    database.deleteRows(table, function (row) {
        return id.includes(row.ID);
    });
    database.commit();
}
