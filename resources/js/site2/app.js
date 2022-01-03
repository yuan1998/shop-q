let Vue = require('vue');
let VueRouter = require('vue-router');
import routes from "./router"
import axios from "axios"
import Vant from 'vant';
import nut from '@nutui/nutui';

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
})

import RootComponent from "./components/layouts/App"

const app = Vue.createApp(RootComponent)
app.config.globalProperties.$http = axios
app.use(router)
    .use(Vant)
    .use(nut)

app.mount('#app')
