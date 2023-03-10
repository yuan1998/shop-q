const Home = () => import("../components/layouts/Home");
const Success = () => import("../components/Success/Index");
const Checkout = () => import("../components/Checkout/Index");
const Detail = () => import("../components/Product/Detail");
const ProductReplyList = () => import("../components/Product/Reply/List");
const OrderIndex = () => import("../components/Order/Index");
const OrderCreate = () => import("../components/Order/Create");
const OrderDetail = () => import("../components/Order/Detail");
const OrderReturnList = () => import("../components/Order/Return/ReturnList");
const LocationIndex = () => import("../components/Location/Index");
const LocationCreate = () => import("../components/Location/Create");
const ComplaintIndex = () => import("../components/Complaint/Index");

export default [
    {path: '/', component: Home},
    {path: '/success', component: Success},
    {path: '/checkout', component: Checkout},
    {
        path: '/detail/:id', component: Detail, props: true
    },
    {
        path: '/order', component: OrderIndex
    },
    {
        path: '/order/create', component: OrderCreate
    },
    {
        path: '/order/detail', component: OrderDetail
    },
    {
        path: '/order/return', component: OrderReturnList
    },

    {
        path: '/location/create', component: LocationCreate
    },
    {
        path: '/location', component: LocationIndex
    },
    {
        path: '/complaint', component: ComplaintIndex
    },
    {
        path: '/replies',
        component: ProductReplyList
    }


]
