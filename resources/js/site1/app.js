let Vue = require('vue');
let VueRouter = require('vue-router');
import routes from "./router"
import axios from "axios"
import Vant from 'vant';
import TawkMessengerVue from '@tawk.to/tawk-messenger-vue-3';

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
})

import RootComponent from "../components/layouts/App"

const app = Vue.createApp(RootComponent)
app.config.globalProperties.$http = axios
app.use(router)
    .use(Vant)

if (window._setting_?.customer?.enable)
    app.use(TawkMessengerVue, {
        propertyId: window._setting_?.customer?.propertyId,
        widgetId: window._setting_?.customer?.widgetId
    });

app.mount('#app')
