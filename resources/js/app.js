require('./bootstrap');
window.Vue = require('vue');
window.VueRouter = require('vue-router');
import routes from "./router"
import axios from "axios"
import {
    Divider,
    Button,
    Swipe,
    SwipeItem,
    Row,
    Col,
    Image,
    Sticky,
    Radio,
    RadioGroup,
    List,
    Skeleton,
    Tab,
    Tabs,
    Field,
    Stepper,
    Empty,
    Loading,
    Cell,
    Icon,
    CellGroup,
    ActionSheet,
    ImagePreview,
    Toast,
    Card,
    Dialog,
    Switch,
    Search,
    SubmitBar,
    AddressEdit,
    AddressList,
    ContactCard,
    Area,
    NavBar
} from 'vant';

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
})

import RootComponent from "./components/layouts/App"

const app = Vue.createApp(RootComponent)
app.config.globalProperties.$http = axios
app.use(router)
    .use(Button)
    .use(Swipe)
    .use(SwipeItem)
    .use(Row)
    .use(Col)
    .use(Image)
    .use(Dialog)
    .use(Sticky)
    .use(List)
    .use(Toast)
    .use(Skeleton)
    .use(Tab)
    .use(Tabs)
    .use(Cell)
    .use(CellGroup)
    .use(Divider)
    .use(ActionSheet)
    .use(Field)
    .use(AddressList)
    .use(Search)
    .use(Loading)
    .use(Switch)
    .use(ContactCard)
    .use(AddressEdit)
    .use(Area)
    .use(Radio)
    .use(RadioGroup)
    .use(Stepper)
    .use(ImagePreview)
    .use(SubmitBar)
    .use(Card)
    .use(Empty)
    .use(NavBar)
    .use(Icon)
console.log("process.env",process.env);
console.log("process.env.MIX_API_URL",process.env.MIX_DISABLE_WECHAT);
console.log("process.env.MIX_API_URL",process.env.MIX_DISABLE_ALIPAY);
app.mount('#app')
