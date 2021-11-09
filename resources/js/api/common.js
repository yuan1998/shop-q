import localStorageDB from 'localStorageDB';

export const database = new localStorageDB("the_north_face", localStorage);


export const getRandomArbitrary = (min, max) => {
    return Math.random() * (max - min) + min;
}

export const toQueryString = (obj) => {
    var parts = [];
    for (var i in obj) {
        if (obj.hasOwnProperty(i)) {
            parts.push(encodeURIComponent(i) + "=" + encodeURIComponent(obj[i]));
        }
    }
    return parts.join("&");
}

export const storageGet = (key) => {
    let value = localStorage.getItem(key);
    return value ? JSON.parse(value) : null;
}

export const storageSet = (key, value) => {
    localStorage.setItem(key, JSON.stringify(value));
}
