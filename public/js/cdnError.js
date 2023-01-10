// 静态资源对应的链接
var staticMap = {
    link: "href",
    script: "src",
};
// <link onerror="onCdnError(this)" href="https://cdn-a.com/index.css" rel="stylesheet"/>
// <script onerror="onCdnError(this)" href="https://cdn-a.com/index.js"></script>
window.onCdnError = function (e) {
    console.log("123",123);
    const nodeName = e.nodeName.toLowerCase();
    const srcName = staticMap[nodeName];
    if (!srcName) {
        return;
    }
    // 获取当前加载失败的链接
    let link = e[srcName];
    let asset = e.dataset['asset'];
    console.log("asset",asset,link,e);
    if (!link || !asset) return;

    // 创建script或者link标签，插入到head中
    const head = document.head || document.getElementsByTagName("head")[0];
    const el = document.createElement(nodeName);
    if (nodeName === "link") {
        el.rel = "stylesheet";
    }
    el[srcName] = asset;
    el.onerror = function () {
        window.onCdnError(el);
    };
    el.setAttribute("crossorigin", "anonymous");
    console.log("el",el);
    head.appendChild(el);
};
