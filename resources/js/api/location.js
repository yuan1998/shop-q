import lodash from 'lodash';
import {database} from "./common";

let table = "locations";
if (!database.tableExists(table)) {
    // create the "books" table
    database.createTable(table, ["name", "phone", "area", "address", "tag", "default", "detail"]);

    // commit the database to localStorage
    // all create/drop/insert/update/delete operations should be committed
    database.commit();
}


const key = "_L_K_"
const chosenKey = "_C_L_K_"

export const getLocationData = () => {
    return database.queryAll(table);
}

export const clearDefault = () => {
    database.update(table, {default: true}, (row) => {
        row.default = false;
        return row;
    })
}

export const addLocationData = (data) => {
    if (data?.default) {
        clearDefault();
    }

    let r = database.insert(table, data);
    database.commit();

    return r;
}

export const editLocationData = (data, id) => {
    let result = lodash.pick(data, ["name", "phone", "area", "address", "tag", "default", "detail"]);

    if (data?.default) {
        clearDefault();
    }
    database.update(table, {ID: id}, (row) => {
        return result;
    })
    database.commit();
}

export const searchLocation = (query, limit = null, start = null) => {
    return database.query(table, query, limit, null);
}

let chosenId = null;
export const getChosenLocation = () => {

    let r;
    if (chosenId) {
        r = searchLocation({
            ID: chosenId,
        }, 1);
        console.log("choseIdData", r);
    }

    if (!r || !r.length) {
        r = database.query(table, null, 1, null, [["default", "DESC"]]);
    }
    return lodash.get(r, '0');
}


export const setChosenLocationId = (id) => {
    console.log("setChosenLocationId", id);
    chosenId = id;
}

