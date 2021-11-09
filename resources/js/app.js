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
    Switch,
    SubmitBar,
    AddressEdit,
    AddressList,
    ContactCard,
    Area,
    NavBar
} from 'vant';
// import {Price, Navbar, Icon} from '@nutui/nutui';
// import '@nutui/nutui/dist/style.css';

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


app.mount('#app')
