(self.webpackChunk=self.webpackChunk||[]).push([[395],{757:(t,e,r)=>{t.exports=r(666)},19:(t,e,r)=>{"use strict";r.d(e,{jn:()=>s,jw:()=>l,BW:()=>d,Fw:()=>p,nA:()=>f,ZN:()=>h,sL:()=>v,dz:()=>m,HG:()=>g,WG:()=>y,I_:()=>w,Qt:()=>x,i$:()=>b});var n=r(757),o=r.n(n),a=r(467),i=r.n(a);function c(t,e,r,n,o,a,i){try{var c=t[a](i),u=c.value}catch(t){return void r(t)}c.done?e(u):Promise.resolve(u).then(n,o)}function u(t){return function(){var e=this,r=arguments;return new Promise((function(n,o){var a=t.apply(e,r);function i(t){c(a,n,o,i,u,"next",t)}function u(t){c(a,n,o,i,u,"throw",t)}i(void 0)}))}}var s=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().get("/api/product/detail",{params:{id:e}});case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),l=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().get("/api/product/list",{params:{page:e}});case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),d=function(){var t=u(o().mark((function t(e,r){var n;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().get("/api/product/replies",{params:{page:e,id:r}});case 2:return n=t.sent,t.abrupt("return",n.data);case 4:case"end":return t.stop()}}),t)})));return function(e,r){return t.apply(this,arguments)}}(),p=function(){var t=u(o().mark((function t(e,r){var n;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().get("/api/order/list",{params:{order_id:e,page:r}});case 2:return n=t.sent,t.abrupt("return",n.data);case 4:case"end":return t.stop()}}),t)})));return function(e,r){return t.apply(this,arguments)}}(),f=function(){var t=u(o().mark((function t(){var e,r,n=arguments;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=n.length>0&&void 0!==n[0]?n[0]:5,t.next=3,i().get("/api/banner/list",{params:{count:e}});case 3:return r=t.sent,t.abrupt("return",r.data);case 5:case"end":return t.stop()}}),t)})));return function(){return t.apply(this,arguments)}}(),h=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().get("/api/order/searchByPhone",{params:{phone:e}});case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),v=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().post("/api/order/store",e);case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),m=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().post("/api/order/outPay",{order_id:e});case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),g=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().get("/api/order/getById",{params:{order_id:e}});case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),y=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().post("/api/order/return/request",e);case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),w=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().post("/api/order/return/shipReturn",e);case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),x=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().post("/api/order/return/cancel",e);case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),b=function(){var t=u(o().mark((function t(e){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,i().post("/api/complaint/store",e);case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()},421:(t,e,r)=>{"use strict";r.d(e,{Fs:()=>c,YS:()=>u,ax:()=>s,hb:()=>l});var n=r(803),o=r.n(n),a=r(611),i=r.n(a),c=new(o())("the_north_face",localStorage),u=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;return i().get(window._setting_,t,e)},s=function(t,e){return Math.random()*(e-t)+t},l=function(t){switch(t.toLowerCase().trim()){case"true":case"yes":case"1":return!0;case"false":case"no":case"0":case null:return!1;default:return Boolean(t)}}},186:(t,e,r)=>{"use strict";r.d(e,{fS:()=>u,qP:()=>s,Yq:()=>l,FB:()=>d,q5:()=>p,sl:()=>f,Ss:()=>h});var n=r(611),o=r.n(n),a=r(421),i="order";a.Fs.tableExists(i)||(a.Fs.createTable(i,["order_id"]),a.Fs.commit());var c=function(t){return!!a.Fs.query(i,{order_id:t}).length},u=function(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];c(t)||(a.Fs.insert(i,{order_id:t}),e&&a.Fs.commit())},s=function(t){for(var e=0;e<t.length;e++){var r=t[e];u(r,!1)}a.Fs.commit()},l=function(){var t=a.Fs.query(i,{},null,null,["order_id","DESC"]);return console.log("orderIdList",t),o().map(t,"order_id").join(",")},d=function(t){t&&(a.Fs.deleteRows(i,{order_id:t}),a.Fs.commit())},p={1:"去支付",2:"退货/退款",3:"去支付",4:"退款中",5:"已发货",6:"订单已取消"},f={1:"未支付",2:"支付成功",3:"支付失败",4:"退货/退款中",5:"已发货",6:"已取消"},h={1:"申请退货退款中",2:"退货退款同意-待发货",3:"退货退款同意-已发货",4:"申请退款",5:"同意退款",6:"取消退款",7:"换货/换款",8:"同意换货/换款-待发货",9:"同意换货/换款-已发货"}},606:(t,e,r)=>{"use strict";r.d(e,{Z:()=>a});var n=r(645),o=r.n(n)()((function(t){return t[1]}));o.push([t.id,".order_index-card[data-v-80352b8a]{background-color:#fff;margin-top:15px;padding-bottom:10px}.order_index-card .actions[data-v-80352b8a],.order_index-card .total_price[data-v-80352b8a]{padding-right:15px;text-align:right}.order_index-card .actions .van-button[data-v-80352b8a],.order_index-card .total_price .van-button[data-v-80352b8a]{margin-right:15px}.order_index-card .actions .van-button[data-v-80352b8a]:last-child,.order_index-card .total_price .van-button[data-v-80352b8a]:last-child{margin-right:0}.order_index-card .total_price[data-v-80352b8a]{font-size:18px;padding:10px}.order_index-card .total_price span[data-v-80352b8a]{color:#777;font-size:13px;margin-right:4px}",""]);const a=o},128:(t,e,r)=>{"use strict";r.d(e,{Z:()=>a});var n=r(645),o=r.n(n)()((function(t){return t[1]}));o.push([t.id,".product_item[data-v-01c0eb4e]{display:flex;max-width:100vw;padding:15px}.product_item .product_thumb[data-v-01c0eb4e]{flex:none}.product_item .product_sku[data-v-01c0eb4e],.product_item .product_title[data-v-01c0eb4e]{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.product_item .product_title[data-v-01c0eb4e]{width:100%}.product_item .product_sku[data-v-01c0eb4e]{background-color:#fafafa;color:#777;display:inline-block;font-size:14px;margin-bottom:6px;margin-top:8px;padding:2px 10px}.product_item .product_text span[data-v-01c0eb4e]{border:1px solid #cd815f;border-radius:2px;color:#cd815f;display:inline-block;font-size:12px;padding:2px 5px}.product_item .product_content[data-v-01c0eb4e]{display:flex;flex:auto;overflow:hidden;padding-left:10px}.product_item .product_content .product_info[data-v-01c0eb4e]{flex:auto;overflow:hidden}.product_item .product_content .product_price[data-v-01c0eb4e]{color:#777;flex:none;line-height:1.8;padding-left:10px;text-align:right}",""]);const a=o},666:t=>{var e=function(t){"use strict";var e,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",i=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag";function u(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{u({},"")}catch(t){u=function(t,e,r){return t[e]=r}}function s(t,e,r,n){var o=e&&e.prototype instanceof m?e:m,a=Object.create(o.prototype),i=new L(n||[]);return a._invoke=function(t,e,r){var n=d;return function(o,a){if(n===f)throw new Error("Generator is already running");if(n===h){if("throw"===o)throw a;return S()}for(r.method=o,r.arg=a;;){var i=r.delegate;if(i){var c=N(i,r);if(c){if(c===v)continue;return c}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===d)throw n=h,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=f;var u=l(t,e,r);if("normal"===u.type){if(n=r.done?h:p,u.arg===v)continue;return{value:u.arg,done:r.done}}"throw"===u.type&&(n=h,r.method="throw",r.arg=u.arg)}}}(t,r,i),a}function l(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=s;var d="suspendedStart",p="suspendedYield",f="executing",h="completed",v={};function m(){}function g(){}function y(){}var w={};u(w,a,(function(){return this}));var x=Object.getPrototypeOf,b=x&&x(x(O([])));b&&b!==r&&n.call(b,a)&&(w=b);var _=y.prototype=m.prototype=Object.create(w);function k(t){["next","throw","return"].forEach((function(e){u(t,e,(function(t){return this._invoke(e,t)}))}))}function E(t,e){function r(o,a,i,c){var u=l(t[o],t,a);if("throw"!==u.type){var s=u.arg,d=s.value;return d&&"object"==typeof d&&n.call(d,"__await")?e.resolve(d.__await).then((function(t){r("next",t,i,c)}),(function(t){r("throw",t,i,c)})):e.resolve(d).then((function(t){s.value=t,i(s)}),(function(t){return r("throw",t,i,c)}))}c(u.arg)}var o;this._invoke=function(t,n){function a(){return new e((function(e,o){r(t,n,e,o)}))}return o=o?o.then(a,a):a()}}function N(t,r){var n=t.iterator[r.method];if(n===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,N(t,r),"throw"===r.method))return v;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var o=l(n,t.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,v;var a=o.arg;return a?a.done?(r[t.resultName]=a.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,v):a:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,v)}function V(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function C(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function L(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(V,this),this.reset(!0)}function O(t){if(t){var r=t[a];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var o=-1,i=function r(){for(;++o<t.length;)if(n.call(t,o))return r.value=t[o],r.done=!1,r;return r.value=e,r.done=!0,r};return i.next=i}}return{next:S}}function S(){return{value:e,done:!0}}return g.prototype=y,u(_,"constructor",y),u(y,"constructor",g),g.displayName=u(y,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===g||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,y):(t.__proto__=y,u(t,c,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},k(E.prototype),u(E.prototype,i,(function(){return this})),t.AsyncIterator=E,t.async=function(e,r,n,o,a){void 0===a&&(a=Promise);var i=new E(s(e,r,n,o),a);return t.isGeneratorFunction(r)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},k(_),u(_,c,"Generator"),u(_,a,(function(){return this})),u(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=O,L.prototype={constructor:L,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(C),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function o(n,o){return c.type="throw",c.arg=t,r.next=n,o&&(r.method="next",r.arg=e),!!o}for(var a=this.tryEntries.length-1;a>=0;--a){var i=this.tryEntries[a],c=i.completion;if("root"===i.tryLoc)return o("end");if(i.tryLoc<=this.prev){var u=n.call(i,"catchLoc"),s=n.call(i,"finallyLoc");if(u&&s){if(this.prev<i.catchLoc)return o(i.catchLoc,!0);if(this.prev<i.finallyLoc)return o(i.finallyLoc)}else if(u){if(this.prev<i.catchLoc)return o(i.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return o(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=e,a?(this.method="next",this.next=a.finallyLoc,v):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),C(r),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var o=n.arg;C(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:O(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),v}},t}(t.exports);try{regeneratorRuntime=e}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=e:Function("r","regeneratorRuntime = r")(e)}},323:(t,e,r)=>{"use strict";r.d(e,{Z:()=>F});var n=r(311),o={class:"order_index-card"},a={key:0,class:"total_price"},i=function(t){return(0,n.pushScopeId)("data-v-80352b8a"),t=t(),(0,n.popScopeId)(),t}((function(){return(0,n.createElementVNode)("span",{class:"total_text"},"合计",-1)})),c={key:1,class:"actions"},u=(0,n.createTextVNode)(" 删除订单 ");r(757);var s=r(871),l=(r(19),{class:"product_item"}),d={class:"product_thumb"},p={class:"product_content"},f={class:"product_info"},h={class:"product_title"},v={class:"product_sku"},m={class:"sku"},g=function(t){return(0,n.pushScopeId)("data-v-01c0eb4e"),t=t(),(0,n.popScopeId)(),t}((function(){return(0,n.createElementVNode)("div",{class:"product_text"},null,-1)})),y={class:"product_price"},w={class:"price"},x={class:"count"};var b=r(611),_=r.n(b);const k={name:"order_product_item",props:["product"],setup:function(t){var e=t.product;return{product:e,image:_().get(JSON.parse(e.images),"0.value"),sku:_().values(JSON.parse(e.sku)).join("/")}}};var E=r(379),N=r.n(E),V=r(128),C={insert:"head",singleton:!1};N()(V.Z,C);V.Z.locals;var L=r(744);const O=(0,L.Z)(k,[["render",function(t,e,r,o,a,i){var c=(0,n.resolveComponent)("van-image");return(0,n.openBlock)(),(0,n.createElementBlock)("div",l,[(0,n.createElementVNode)("div",d,[(0,n.createVNode)(c,{width:"80",height:"80",fit:"cover",src:"/storage/"+o.image},null,8,["src"])]),(0,n.createElementVNode)("div",p,[(0,n.createElementVNode)("div",f,[(0,n.createElementVNode)("div",h,(0,n.toDisplayString)(o.product.title),1),(0,n.createElementVNode)("div",v,[(0,n.createElementVNode)("div",m,(0,n.toDisplayString)(o.sku),1)]),g]),(0,n.createElementVNode)("div",y,[(0,n.createElementVNode)("div",w," ¥ "+(0,n.toDisplayString)(o.product.price),1),(0,n.createElementVNode)("div",x," x"+(0,n.toDisplayString)(o.product.count),1)])])])}],["__scopeId","data-v-01c0eb4e"]]);var S=r(243),P=r(186);const j={name:"",props:["product","hideAction","hideTotal"],components:{ProductItem:O},setup:function(t){var e=(0,S.useRouter)(),r=(0,n.inject)("order-index").deleteOrder,o=t.product,a=t.hideAction,i=t.hideTotal,c=(0,n.reactive)(o),u=function(t){e.push({path:"/order/detail",query:{order_id:t}})};return{item:c,hideAction:a,hideTotal:i,statusList:P.sl,buttonText:P.q5,handleStatusClick:function(){var t=c.order_id;switch(c.status){case 1:case 3:!function(t){s.Toast.loading("获取支付信息..."),window.location.href="/api/pay?order_id=".concat(t)}(t);break;case 2:u(t);break;default:(0,s.Toast)(P.sl[c.status])}},handleLogisticClick:function(){c.logistic_number?window.location.href="https://m.kuaidi100.com/app/query/?com=shunfeng&nu=".concat(c.logistic_number,"&coname=px&callbackurl=").concat(window.location.href):(0,s.Toast)("未发货,请耐心等待")},handleComplaintClick:function(t){e.push({path:"/complaint",query:{order_id:t}})},deleteOrder:r,handleToDetail:u}}};var B=r(606),T={insert:"head",singleton:!1};N()(B.Z,T);B.Z.locals;const F=(0,L.Z)(j,[["render",function(t,e,r,s,l,d){var p=(0,n.resolveComponent)("van-cell"),f=(0,n.resolveComponent)("ProductItem"),h=(0,n.resolveComponent)("van-button");return(0,n.openBlock)(),(0,n.createElementBlock)("div",o,[(0,n.createVNode)(p,{title:s.item.order_id,value:s.statusList[s.item.status]},null,8,["title","value"]),(0,n.createElementVNode)("div",{class:"order_index-card-product",onClick:e[0]||(e[0]=function(t){return s.handleToDetail(s.item.order_id)})},[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(s.item.snapshot,(function(t){return(0,n.openBlock)(),(0,n.createBlock)(f,{key:t.id,product:t},null,8,["product"])})),128))]),s.hideTotal?(0,n.createCommentVNode)("",!0):((0,n.openBlock)(),(0,n.createElementBlock)("div",a,[i,(0,n.createElementVNode)("strong",null,"¥"+(0,n.toDisplayString)(s.item.price),1)])),s.hideAction?(0,n.createCommentVNode)("",!0):((0,n.openBlock)(),(0,n.createElementBlock)("div",c,[(0,n.createVNode)(h,{type:"default",size:"small",onClick:e[1]||(e[1]=function(t){return s.deleteOrder(s.item.order_id,s.item.currentPage)})},{default:(0,n.withCtx)((function(){return[u]})),_:1}),(0,n.createVNode)(h,{type:"default",size:"small",onClick:e[2]||(e[2]=function(t){return s.handleStatusClick()})},{default:(0,n.withCtx)((function(){return[(0,n.createTextVNode)((0,n.toDisplayString)(s.buttonText[s.item.status]),1)]})),_:1}),1!==s.item.status?((0,n.openBlock)(),(0,n.createBlock)(h,{key:0,type:"default",size:"small",onClick:e[3]||(e[3]=function(t){return s.handleLogisticClick()})},{default:(0,n.withCtx)((function(){return[(0,n.createTextVNode)((0,n.toDisplayString)(s.item.logistic_number?"查看物流":"未发货"),1)]})),_:1})):(0,n.createCommentVNode)("",!0)]))])}],["__scopeId","data-v-80352b8a"]])},395:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>V});var n=r(311),o={class:"order_index"},a={style:{"font-size":"16px"}},i=(0,n.createElementVNode)("p",null,"Q: 为什么没有或者缺失了我的订单?",-1),c=(0,n.createTextVNode)("A: 系统网络波动会导致本地订单数据丢失 "),u=(0,n.createElementVNode)("br",null,null,-1),s=(0,n.createTextVNode)(" 可以点击下方文字或者右上角的查询图标手动输入收货人电话 "),l=(0,n.createElementVNode)("br",null,null,-1),d={class:"content"},p=(0,n.createElementVNode)("div",{class:"van-action-sheet__gap"},null,-1);var f=r(757),h=r.n(f),v=r(611),m=r.n(v),g=r(186),y=r(19),w=r(871);function x(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,n)}return r}function b(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?x(Object(r),!0).forEach((function(e){_(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):x(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function _(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}function k(t,e,r,n,o,a,i){try{var c=t[a](i),u=c.value}catch(t){return void r(t)}c.done?e(u):Promise.resolve(u).then(n,o)}function E(t){return function(){var e=this,r=arguments;return new Promise((function(n,o){var a=t.apply(e,r);function i(t){k(a,n,o,i,c,"next",t)}function c(t){k(a,n,o,i,c,"throw",t)}i(void 0)}))}}const N={name:"order_index",components:{OrderItem:r(323).Z},setup:function(){var t=(0,n.reactive)({list:[],loading:!1,listLoading:!1,finished:!1,show:!1,searchValue:"",currentPage:null}),e=function(){var e=E(h().mark((function e(r){var n,o,a,i,c,u,s;return h().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(r=r||!t.currentPage?1:t.currentPage+1,!(n=(0,g.Yq)())){e.next=16;break}return t.listLoading=!0,e.next=6,(0,y.Fw)(n,r);case 6:i=e.sent,c=i.data.current_page,t.listLoading=!1,u=null===(o=i.data)||void 0===o||null===(a=o.data)||void 0===a?void 0:a.map((function(t){return b(b({},t),{},{custom_info:JSON.parse(t.custom_info),snapshot:[].concat(JSON.parse(t.snapshot)),currentPage:c})})),s=m().uniqBy(t.list.concat(u),"order_id"),t.list=m().sortBy(s,"id").reverse(),t.currentPage=c,i.data.last_page<=c&&(t.finished=!0),e.next=17;break;case 16:t.finished=!0;case 17:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),r=function(){var r=E(h().mark((function r(){var n,o;return h().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(!(n=t.searchValue)){r.next=14;break}if(/^[1][345789][0-9]{9}$/.test(n)){r.next=5;break}return w.Toast.fail("请输入正确的电话号码"),r.abrupt("return");case 5:return w.Toast.loading("获取订单中,请稍等..."),r.next=8,(0,y.ZN)(n);case 8:return o=r.sent,(0,g.qP)(o.data),w.Toast.success("获取订单中成功"),t.finished=!1,r.next=14,e(1);case 14:t.show=!1;case 15:case"end":return r.stop()}}),r)})));return function(){return r.apply(this,arguments)}}(),o=function(r){var n,o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1;w.Dialog.confirm({title:"删除订单",message:"是否要删除订单",beforeClose:(n=E(h().mark((function n(a){return h().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if("confirm"!==a){n.next=6;break}return t.list=t.list.filter((function(t){return t.order_id!==r})),(0,g.FB)(r),n.next=5,e(o);case 5:w.Toast.success("订单删除成功.");case 6:return n.abrupt("return",!0);case 7:case"end":return n.stop()}}),n)}))),function(t){return n.apply(this,arguments)})})};return(0,n.provide)("order-index",{deleteOrder:o}),b(b({},(0,n.toRefs)(t)),{},{pullOrderId:e,onClickRight:function(){t.show=!0},onCancel:r,deleteOrder:o,setting:window._setting_})}};const V=(0,r(744).Z)(N,[["render",function(t,e,r,f,h,v){var m=(0,n.resolveComponent)("van-icon"),g=(0,n.resolveComponent)("van-nav-bar"),y=(0,n.resolveComponent)("OrderItem"),w=(0,n.resolveComponent)("van-list"),x=(0,n.resolveComponent)("van-search"),b=(0,n.resolveComponent)("van-action-sheet"),_=(0,n.resolveComponent)("van-skeleton");return(0,n.openBlock)(),(0,n.createElementBlock)("div",o,[(0,n.createVNode)(_,{row:20,loading:!t.list&&t.listLoading},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(g,{fixed:"",placeholder:"",title:"全部订单"},{left:(0,n.withCtx)((function(){return[(0,n.createVNode)(m,{onClick:e[0]||(e[0]=function(e){return t.$router.push({path:"/"})}),name:"shop",size:"18"})]})),right:(0,n.withCtx)((function(){return[(0,n.createVNode)(m,{onClick:f.onClickRight,name:"search",size:"18"},null,8,["onClick"])]})),_:1}),(0,n.createVNode)(w,{modelValue:t.listLoading,"onUpdate:modelValue":e[2]||(e[2]=function(e){return t.listLoading=e}),finished:t.finished,onLoad:f.pullOrderId},{finished:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",a,[i,(0,n.createElementVNode)("p",null,[c,u,s,l,(0,n.createElementVNode)("span",{style:{color:"#4aa0e6"},onClick:e[1]||(e[1]=function(){return f.onClickRight&&f.onClickRight.apply(f,arguments)})},"获取订单")]),(0,n.createElementVNode)("p",null," 官方客服电话: "+(0,n.toDisplayString)(f.setting.customer_phone),1),(0,n.createElementVNode)("p",null," 官方客服微信: "+(0,n.toDisplayString)(f.setting.customer_wechat),1)])]})),default:(0,n.withCtx)((function(){return[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(t.list,(function(t){return(0,n.openBlock)(),(0,n.createBlock)(y,{product:t,key:t.id,onDeleteRow:f.deleteOrder},null,8,["product","onDeleteRow"])})),128))]})),_:1},8,["modelValue","finished","onLoad"]),(0,n.createVNode)(b,{show:t.show,"onUpdate:show":e[5]||(e[5]=function(e){return t.show=e}),description:"输入手机号码搜索订单"},{default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",d,[(0,n.createVNode)(x,{modelValue:t.searchValue,"onUpdate:modelValue":e[3]||(e[3]=function(e){return t.searchValue=e}),placeholder:"请输入收货人电话号码"},null,8,["modelValue"]),p,(0,n.createElementVNode)("button",{onClick:e[4]||(e[4]=function(){return f.onCancel&&f.onCancel.apply(f,arguments)}),type:"button",class:"van-action-sheet__cancel"},(0,n.toDisplayString)(t.searchValue?"查询":"取消"),1)])]})),_:1},8,["show"])]})),_:1},8,["loading"])])}]])}}]);