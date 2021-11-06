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
