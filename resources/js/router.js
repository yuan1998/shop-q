import Home from "./components/layouts/Home"
import Success from "./components/Success/Index"
import Checkout from "./components/Checkout/Index"
import Detail from "./components/Product/Detail"
import Create from "./components/Order/Create"

export default [
    {path: '/', component: Home},
    {path: '/success', component: Success},
    {path: '/checkout', component: Checkout},
    {
        path: '/detail/:id', component: Detail, props: true
    },
    {
        path: '/order/create', component: Create
    },

]
