(self.webpackChunk=self.webpackChunk||[]).push([[98],{757:(e,t,r)=>{e.exports=r(666)},19:(e,t,r)=>{"use strict";r.d(t,{jn:()=>s,jw:()=>l,BW:()=>d,Fw:()=>p,nA:()=>f,ZN:()=>v,sL:()=>h,dz:()=>m,HG:()=>g,WG:()=>y,I_:()=>b,Qt:()=>x,i$:()=>w});var n=r(757),o=r.n(n),a=r(467),c=r.n(a);function i(e,t,r,n,o,a,c){try{var i=e[a](c),u=i.value}catch(e){return void r(e)}i.done?t(u):Promise.resolve(u).then(n,o)}function u(e){return function(){var t=this,r=arguments;return new Promise((function(n,o){var a=e.apply(t,r);function c(e){i(a,n,o,c,u,"next",e)}function u(e){i(a,n,o,c,u,"throw",e)}c(void 0)}))}}var s=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().get("/api/product/detail",{params:{id:t}});case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),l=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().get("/api/product/list",{params:{page:t}});case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),d=function(){var e=u(o().mark((function e(t,r){var n;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().get("/api/product/replies",{params:{page:t,id:r}});case 2:return n=e.sent,e.abrupt("return",n.data);case 4:case"end":return e.stop()}}),e)})));return function(t,r){return e.apply(this,arguments)}}(),p=function(){var e=u(o().mark((function e(t,r){var n;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().get("/api/order/list",{params:{order_id:t,page:r}});case 2:return n=e.sent,e.abrupt("return",n.data);case 4:case"end":return e.stop()}}),e)})));return function(t,r){return e.apply(this,arguments)}}(),f=function(){var e=u(o().mark((function e(){var t,r,n=arguments;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t=n.length>0&&void 0!==n[0]?n[0]:5,e.next=3,c().get("/api/banner/list",{params:{count:t}});case 3:return r=e.sent,e.abrupt("return",r.data);case 5:case"end":return e.stop()}}),e)})));return function(){return e.apply(this,arguments)}}(),v=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().get("/api/order/searchByPhone",{params:{phone:t}});case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),h=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().post("/api/order/store",t);case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),m=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().post("/api/order/outPay",{order_id:t});case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),g=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().get("/api/order/getById",{params:{order_id:t}});case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),y=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().post("/api/order/return/request",t);case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),b=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().post("/api/order/return/shipReturn",t);case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),x=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().post("/api/order/return/cancel",t);case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),w=function(){var e=u(o().mark((function e(t){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c().post("/api/complaint/store",t);case 2:return r=e.sent,e.abrupt("return",r.data);case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()},421:(e,t,r)=>{"use strict";r.d(t,{Fs:()=>i,YS:()=>u,ax:()=>s,hb:()=>l});var n=r(803),o=r.n(n),a=r(611),c=r.n(a),i=new(o())("the_north_face",localStorage),u=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;return c().get(window._setting_,e,t)},s=function(e,t){return Math.random()*(t-e)+e},l=function(e){switch(e.toLowerCase().trim()){case"true":case"yes":case"1":return!0;case"false":case"no":case"0":case null:return!1;default:return Boolean(e)}}},583:(e,t,r)=>{"use strict";r.d(t,{Z:()=>a});var n=r(645),o=r.n(n)()((function(e){return e[1]}));o.push([e.id,".reply-title[data-v-76489290]{align-items:center;color:#888;display:flex;font-size:20px}.reply-comment[data-v-76489290]{color:#555;font-size:18px;margin-bottom:15px;margin-top:15px}.reply-image[data-v-76489290]{border:1px solid #999;border-radius:3px;margin-right:10px;padding:3px}",""]);const a=o},830:(e,t,r)=>{"use strict";r.d(t,{Z:()=>a});var n=r(645),o=r.n(n)()((function(e){return e[1]}));o.push([e.id,".product_detail[data-v-340403b2]{background-color:#ededed;padding-bottom:80px}.product_detail .product_info-title[data-v-340403b2]{font-size:20px;line-height:1.3;padding:0 20px 15px}.product_detail .product_info-price[data-v-340403b2]{display:flex;padding:15px 20px}.product_detail .product_info-price .product_info-left[data-v-340403b2]{flex:none}.product_detail .product_info-price .product_info-right[data-v-340403b2]{align-items:center;color:#fff;display:flex;flex:none;line-height:1.4;margin-left:auto;text-align:right}.product_detail .product_info-price .product_info-right p[data-v-340403b2]{margin:0;padding:0}.product_detail .product_info-price .pre_sale[data-v-340403b2]{display:inline-block;margin-right:10px;width:100px}.product_detail .product_info-price .sales[data-v-340403b2]{align-items:center;color:#999;display:flex}.product_detail .product_info-border[data-v-340403b2]{background-color:#fff;border-radius:8px;overflow:hidden}.product_detail .product_info[data-v-340403b2]{padding:10px}.product_detail .product_actions-button[data-v-340403b2]{margin-left:10px}.product_detail .product_actions_icon[data-v-340403b2]{padding:10px 7px;text-align:center}.product_detail .product_actions_icon .icon-text[data-v-340403b2]{color:#999;font-size:13px;padding-top:7px;white-space:nowrap}.product_detail .product-reply_container[data-v-340403b2],.product_detail .product_shop[data-v-340403b2]{padding:10px}.product_detail .product-reply_list .empty[data-v-340403b2]{color:#999;font-size:16px;padding:30px;text-align:center}.product_content[data-v-340403b2]{background-color:#fff}.product_content .product_content-title[data-v-340403b2]{font-size:20px;padding-bottom:10px;padding-left:20px}.product-image_swiper[data-v-340403b2]{height:70vw;max-height:400px}.product-image[data-v-340403b2]{height:100%;-o-object-fit:cover;object-fit:cover;width:100%}.nut-navbar[data-v-340403b2]{margin-bottom:0}.product_actions[data-v-340403b2]{align-items:center;background-color:#fff;bottom:0;display:flex;justify-content:space-between;left:0;margin:0 auto;max-width:750px;padding:10px;position:fixed;right:0;width:100%;z-index:2}",""]);const a=o},307:(e,t,r)=>{"use strict";r.d(t,{Z:()=>a});var n=r(645),o=r.n(n)()((function(e){return e[1]}));o.push([e.id,".van-swipe__indicators{background-color:rgba(0,0,0,.2);border-radius:5px;padding:7px}.van-swipe__indicator--active{background-color:#fff}.product_content-description{padding:10px}.product_content-description img{height:100%;-o-object-fit:cover;object-fit:cover;width:100%}.price_text{align-items:baseline;color:red;display:flex;flex:none;font-size:26px;font-weight:700}.price_text .syb{font-size:16px}.price_text .origin_price{color:#b3b3b3;font-size:22px;font-weight:400;margin-left:15px;text-decoration:line-through}",""]);const a=o},780:(e,t,r)=>{"use strict";r.d(t,{Z:()=>a});var n=r(645),o=r.n(n)()((function(e){return e[1]}));o.push([e.id,".action-content[data-v-9b1d9f2c]{display:flex;flex-direction:column;height:70vh;padding:20px}.action-content .flex-container[data-v-9b1d9f2c]{display:flex}.action-content .flex-container .header-content_image[data-v-9b1d9f2c]{flex:none;height:80px;width:80px}.action-content .flex-container .header_content[data-v-9b1d9f2c]{flex:auto;padding-left:20px}.action-content .action-content_footer[data-v-9b1d9f2c],.action-content .action-content_header[data-v-9b1d9f2c]{flex:none}.action-content .action-content_step[data-v-9b1d9f2c]{flex:auto;overflow:scroll}.action-content .action_text[data-v-9b1d9f2c]{color:#999;font-size:14px}.action-content .sku_values[data-v-9b1d9f2c]{display:flex;flex-wrap:wrap}.action-content .sku_name[data-v-9b1d9f2c]{font-size:16px;padding-bottom:12px}.action-content .sku_value-image[data-v-9b1d9f2c]{display:inline-block;max-width:100px;min-height:80px;min-width:80px}.action-content .sku_value-image-preview[data-v-9b1d9f2c]{background-color:rgba(0,0,0,.4);border-bottom-left-radius:4px;color:#fff;height:18px;line-height:18px;position:absolute;right:0;text-align:center;top:0;width:18px;z-index:3}.action-content .sku_value[data-v-9b1d9f2c]{background-color:#f7f8fa;flex:none;margin-bottom:15px;margin-right:15px;text-align:center}.action-content .sku_value .sku_value-text[data-v-9b1d9f2c]{color:#333;padding:8px 12px}.action-content .sku_value.selected[data-v-9b1d9f2c]{background-color:#fde7ea!important}.action-content .sku_value.selected .sku_value-text[data-v-9b1d9f2c]{color:#ce758b!important}",""]);const a=o},666:e=>{var t=function(e){"use strict";var t,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",c=o.asyncIterator||"@@asyncIterator",i=o.toStringTag||"@@toStringTag";function u(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{u({},"")}catch(e){u=function(e,t,r){return e[t]=r}}function s(e,t,r,n){var o=t&&t.prototype instanceof m?t:m,a=Object.create(o.prototype),c=new O(n||[]);return a._invoke=function(e,t,r){var n=d;return function(o,a){if(n===f)throw new Error("Generator is already running");if(n===v){if("throw"===o)throw a;return S()}for(r.method=o,r.arg=a;;){var c=r.delegate;if(c){var i=E(c,r);if(i){if(i===h)continue;return i}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===d)throw n=v,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=f;var u=l(e,t,r);if("normal"===u.type){if(n=r.done?v:p,u.arg===h)continue;return{value:u.arg,done:r.done}}"throw"===u.type&&(n=v,r.method="throw",r.arg=u.arg)}}}(e,r,c),a}function l(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}e.wrap=s;var d="suspendedStart",p="suspendedYield",f="executing",v="completed",h={};function m(){}function g(){}function y(){}var b={};u(b,a,(function(){return this}));var x=Object.getPrototypeOf,w=x&&x(x(j([])));w&&w!==r&&n.call(w,a)&&(b=w);var _=y.prototype=m.prototype=Object.create(b);function k(e){["next","throw","return"].forEach((function(t){u(e,t,(function(e){return this._invoke(t,e)}))}))}function N(e,t){function r(o,a,c,i){var u=l(e[o],e,a);if("throw"!==u.type){var s=u.arg,d=s.value;return d&&"object"==typeof d&&n.call(d,"__await")?t.resolve(d.__await).then((function(e){r("next",e,c,i)}),(function(e){r("throw",e,c,i)})):t.resolve(d).then((function(e){s.value=e,c(s)}),(function(e){return r("throw",e,c,i)}))}i(u.arg)}var o;this._invoke=function(e,n){function a(){return new t((function(t,o){r(e,n,t,o)}))}return o=o?o.then(a,a):a()}}function E(e,r){var n=e.iterator[r.method];if(n===t){if(r.delegate=null,"throw"===r.method){if(e.iterator.return&&(r.method="return",r.arg=t,E(e,r),"throw"===r.method))return h;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return h}var o=l(n,e.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,h;var a=o.arg;return a?a.done?(r[e.resultName]=a.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=t),r.delegate=null,h):a:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,h)}function V(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function C(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function O(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(V,this),this.reset(!0)}function j(e){if(e){var r=e[a];if(r)return r.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var o=-1,c=function r(){for(;++o<e.length;)if(n.call(e,o))return r.value=e[o],r.done=!1,r;return r.value=t,r.done=!0,r};return c.next=c}}return{next:S}}function S(){return{value:t,done:!0}}return g.prototype=y,u(_,"constructor",y),u(y,"constructor",g),g.displayName=u(y,i,"GeneratorFunction"),e.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===g||"GeneratorFunction"===(t.displayName||t.name))},e.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,y):(e.__proto__=y,u(e,i,"GeneratorFunction")),e.prototype=Object.create(_),e},e.awrap=function(e){return{__await:e}},k(N.prototype),u(N.prototype,c,(function(){return this})),e.AsyncIterator=N,e.async=function(t,r,n,o,a){void 0===a&&(a=Promise);var c=new N(s(t,r,n,o),a);return e.isGeneratorFunction(r)?c:c.next().then((function(e){return e.done?e.value:c.next()}))},k(_),u(_,i,"Generator"),u(_,a,(function(){return this})),u(_,"toString",(function(){return"[object Generator]"})),e.keys=function(e){var t=[];for(var r in e)t.push(r);return t.reverse(),function r(){for(;t.length;){var n=t.pop();if(n in e)return r.value=n,r.done=!1,r}return r.done=!0,r}},e.values=j,O.prototype={constructor:O,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=t,this.done=!1,this.delegate=null,this.method="next",this.arg=t,this.tryEntries.forEach(C),!e)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=t)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var r=this;function o(n,o){return i.type="throw",i.arg=e,r.next=n,o&&(r.method="next",r.arg=t),!!o}for(var a=this.tryEntries.length-1;a>=0;--a){var c=this.tryEntries[a],i=c.completion;if("root"===c.tryLoc)return o("end");if(c.tryLoc<=this.prev){var u=n.call(c,"catchLoc"),s=n.call(c,"finallyLoc");if(u&&s){if(this.prev<c.catchLoc)return o(c.catchLoc,!0);if(this.prev<c.finallyLoc)return o(c.finallyLoc)}else if(u){if(this.prev<c.catchLoc)return o(c.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<c.finallyLoc)return o(c.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===e||"continue"===e)&&a.tryLoc<=t&&t<=a.finallyLoc&&(a=null);var c=a?a.completion:{};return c.type=e,c.arg=t,a?(this.method="next",this.next=a.finallyLoc,h):this.complete(c)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),h},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),C(r),h}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var n=r.completion;if("throw"===n.type){var o=n.arg;C(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(e,r,n){return this.delegate={iterator:j(e),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=t),h}},e}(e.exports);try{regeneratorRuntime=t}catch(e){"object"==typeof globalThis?globalThis.regeneratorRuntime=t:Function("r","regeneratorRuntime = r")(t)}},274:(e,t,r)=>{"use strict";r.d(t,{Z:()=>f});var n=r(311),o={class:"reply-title"},a={class:"reply-comment"},c={key:0,class:"reply-images"};var i=r(871);const u={name:"reply-item",props:["reply"],setup:function(e){var t=e.reply,r=(0,n.computed)((function(){return/http(s)?:\/\//.test(t.thumb)?t.thumb:"/storage/".concat(t.thumb)})),o=(0,n.computed)((function(){var e=t.username;return"".concat(e.substring(0,1),"**").concat(e.substring(e.length-1,e.length))})),a=(0,n.computed)((function(){var e=null==t?void 0:t.images;return e?JSON.parse(e):null}));return{reply:t,thumbUrl:r,username:o,images:a,handleImageClick:function(e){a.value&&(0,i.ImagePreview)({images:a.value,startPosition:e,closeable:!0})}}}};var s=r(379),l=r.n(s),d=r(583),p={insert:"head",singleton:!1};l()(d.Z,p);d.Z.locals;const f=(0,r(744).Z)(u,[["render",function(e,t,r,i,u,s){var l=(0,n.resolveComponent)("van-image"),d=(0,n.resolveComponent)("van-cell");return(0,n.openBlock)(),(0,n.createBlock)(d,null,{title:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",o,[(0,n.createVNode)(l,{src:i.thumbUrl,width:"35",height:"35",fit:"cover",round:"",style:{"margin-right":"15px"}},null,8,["src"]),(0,n.createTextVNode)(" "+(0,n.toDisplayString)(i.username),1)])]})),label:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",a,(0,n.toDisplayString)(i.reply.comment),1),i.images?((0,n.openBlock)(),(0,n.createElementBlock)("div",c,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(i.images,(function(e,t){return(0,n.openBlock)(),(0,n.createBlock)(l,{onClick:function(e){return i.handleImageClick(t)},class:"reply-image",width:"60",height:"60",fit:"cover",key:t,src:e},null,8,["onClick","src"])})),128))])):(0,n.createCommentVNode)("",!0)]})),_:1})}],["__scopeId","data-v-76489290"]])},98:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>Oe});var n=r(311),o=function(e){return(0,n.pushScopeId)("data-v-340403b2"),e=e(),(0,n.popScopeId)(),e},a={class:"product_detail"},c={class:"product_images"},i=["src"],u={class:"product_info"},s={class:"product_info-border"},l={class:"product_info-price"},d={class:"product_info-left"},p={class:"price_text"},f={class:"red_price"},v=o((function(){return(0,n.createElementVNode)("span",{class:"syb"},"¥",-1)})),h={key:0,class:"origin_price"},m=o((function(){return(0,n.createElementVNode)("span",{class:"syb"},"¥",-1)})),g={class:"product_info-right"},y={class:"sales"},b={class:"product_info-title"},x={class:"product-reply_container"},w={class:"product_info-border"},_={style:{"font-size":"21px"}},k=(0,n.createTextVNode)(" 更多 "),N={class:"product-reply_list"},E={key:1,class:"empty"},V={key:0,class:"product_shop"},C=["src"],O={class:"product_content"},j=o((function(){return(0,n.createElementVNode)("div",{class:"product_content-title"}," 商品详情 ",-1)})),S={class:"product_content-description"},B=["innerHTML"],P={class:"product_actions"},L=o((function(){return(0,n.createElementVNode)("div",{class:"icon-text"}," 店铺 ",-1)})),z=o((function(){return(0,n.createElementVNode)("div",{class:"icon-text"}," 客服 ",-1)})),D=o((function(){return(0,n.createElementVNode)("div",{class:"icon-text"}," 收藏 ",-1)})),T=(0,n.createTextVNode)(" 立即购买 ");var F=r(757),I=r.n(F),Z=r(871),G=r(243),R=r(19),M=function(e){return(0,n.pushScopeId)("data-v-9b1d9f2c"),e=e(),(0,n.popScopeId)(),e},A={class:"action-content"},J={class:"action-content_header"},U={class:"flex-container"},Y={class:"header-content_image"},$=["src"],q={class:"header_content"},H={class:"price_text"},W=M((function(){return(0,n.createElementVNode)("span",{class:"syb"},"¥",-1)})),Q=M((function(){return(0,n.createElementVNode)("div",{class:"action_text"}," 剩余 21 件 ",-1)})),K={class:"action_text"},X={class:"action-content_step"},ee={class:"sku_name"},te={class:"sku_values"},re=["onClick"],ne={class:"sku_value-text"},oe={class:"action-content_footer"},ae=(0,n.createTextVNode)(" 立即购买 ");function ce(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function ie(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?ce(Object(r),!0).forEach((function(t){ue(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):ce(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function ue(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const se={name:"sku",props:["product","show"],setup:function(e){var t=e.product,r=(0,n.reactive)({select:{},count:1,selectPhoto:null,skuArr:[]}),o=(0,n.inject)("product"),a=o.buyProduct,c=o.hideSku;(0,n.onMounted)((function(){var e,n=JSON.parse(t.attribute.skus);r.skuArr=null==n||null===(e=n.sort((function(e,t){return t.order-e.order})))||void 0===e?void 0:e.map((function(e){return ie(ie({},e),{},{data:t.skus[e.name]})})),n.forEach((function(e){r.select[e.name]=""}))}));var i=(0,n.computed)((function(){var e=[];return Object.keys(r.select).forEach((function(t){r.select[t]||e.push(t)})),e.join(" ")})),u=(0,n.computed)((function(){var e=[];return Object.keys(r.select).forEach((function(t){e.push(r.select[t])})),e.join(" ")}));return ie({selectSku:function(e,t){r.select[e]=t.title,t.value&&(r.selectPhoto="/storage/".concat(t.value))},imagePreview:function(e){(0,Z.ImagePreview)([e])},onCancel:function(){},photo:(0,n.computed)((function(){if(r.selectPhoto)return r.selectPhoto;var e=t.images[0].value;return"/storage/".concat(e)})),unSelectField:i,selectField:u,handleSubmit:function(){var e=i.value;e?(0,Z.Toast)("请选择 ".concat(e)):a(r)},hideSku:c},(0,n.toRefs)(r))}};var le=r(379),de=r.n(le),pe=r(780),fe={insert:"head",singleton:!1};de()(pe.Z,fe);pe.Z.locals;var ve=r(744);const he=(0,ve.Z)(se,[["render",function(e,t,r,o,a,c){var i=(0,n.resolveComponent)("van-divider"),u=(0,n.resolveComponent)("van-stepper"),s=(0,n.resolveComponent)("van-field"),l=(0,n.resolveComponent)("van-button"),d=(0,n.resolveComponent)("van-action-sheet");return(0,n.openBlock)(),(0,n.createBlock)(d,{show:r.show,"onUpdate:show":t[2]||(t[2]=function(e){return r.show=e}),closeable:"",onClose:o.hideSku},{default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",A,[(0,n.createElementVNode)("div",J,[(0,n.createElementVNode)("div",U,[(0,n.createElementVNode)("div",Y,[(0,n.createElementVNode)("img",{onClick:t[0]||(t[0]=function(e){return o.imagePreview(o.photo)}),src:o.photo,alt:"",class:"mc-img"},null,8,$)]),(0,n.createElementVNode)("div",q,[(0,n.createElementVNode)("div",H,[W,(0,n.createTextVNode)(" "+(0,n.toDisplayString)(r.product.price),1)]),Q,(0,n.createElementVNode)("div",K,(0,n.toDisplayString)(o.unSelectField?"请选择 ".concat(o.unSelectField):"已选择  ".concat(o.selectField)),1)])]),(0,n.createVNode)(i)]),(0,n.createElementVNode)("div",X,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(e.skuArr,(function(t,r){return(0,n.openBlock)(),(0,n.createElementBlock)("div",{class:"action-content_step_sku_item",key:r},[(0,n.createElementVNode)("div",ee,(0,n.toDisplayString)(t.name),1),(0,n.createElementVNode)("div",te,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(t.data,(function(r,a){return(0,n.openBlock)(),(0,n.createElementBlock)("div",{onClick:function(e){return o.selectSku(t.name,r)},key:a,class:(0,n.normalizeClass)(["sku_value",e.select[t.name]===r.title?"selected":""])},[(0,n.createElementVNode)("div",ne,(0,n.toDisplayString)(r.title),1)],10,re)})),128))]),(0,n.createVNode)(i)])})),128)),(0,n.createVNode)(s,{name:"stepper",label:"购买数量","input-align":"right"},{input:(0,n.withCtx)((function(){return[(0,n.createVNode)(u,{modelValue:e.count,"onUpdate:modelValue":t[1]||(t[1]=function(t){return e.count=t})},null,8,["modelValue"])]})),_:1})]),(0,n.createElementVNode)("div",oe,[(0,n.createVNode)(i),(0,n.createVNode)(l,{onClick:o.handleSubmit,size:"large",round:"",color:"linear-gradient(to right, #ff6034, #ee0a24)"},{default:(0,n.withCtx)((function(){return[ae]})),_:1},8,["onClick"])])])]})),_:1},8,["show","onClose"])}],["__scopeId","data-v-9b1d9f2c"]]);var me=r(274),ge=r(421);function ye(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function be(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?ye(Object(r),!0).forEach((function(t){xe(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):ye(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function xe(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function we(e,t,r,n,o,a,c){try{var i=e[a](c),u=i.value}catch(e){return void r(e)}i.done?t(u):Promise.resolve(u).then(n,o)}function _e(e){return function(){var t=this,r=arguments;return new Promise((function(n,o){var a=e.apply(t,r);function c(e){we(a,n,o,c,i,"next",e)}function i(e){we(a,n,o,c,i,"throw",e)}c(void 0)}))}}const ke={name:"product_detail",components:{Sku:he,ReplyItem:me.Z},setup:function(){var e=(0,G.useRoute)(),t=(0,G.useRouter)(),r=(0,n.reactive)({loading:!0,show:!1,id:"",like:!1,data:{}}),o=function(){var e=_e(I().mark((function e(t){var n,o,a;return I().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,(0,R.jn)(t);case 2:0===(n=e.sent).status&&(o=n.data,a=JSON.parse(o.skus),r.data=be(be({},o),{},{images:JSON.parse(o.images),attributes:JSON.parse(o.attributes),skus:a}));case 4:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}();(0,n.onMounted)(_e(I().mark((function t(){return I().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r.id=e.params.id,t.next=3,o(r.id);case 3:r.loading=!1;case 4:case"end":return t.stop()}}),t)}))));var a=function(e){var n,o,a={sku:JSON.stringify(e.select),count:e.count,product_id:r.id,image:null===(n=r.data)||void 0===n||null===(o=n.images[0])||void 0===o?void 0:o.value,title:r.data.title,price:r.data.price};t.push({path:"/order/create",query:a})};return(0,n.provide)("product",{buyProduct:a,hideSku:function(){r.show=!1}}),be(be({},(0,n.toRefs)(r)),{},{img:(0,ge.YS)("product_image","https://pic.imgdb.cn/item/619aee2c2ab3f51d9156d104.png"),showSku:function(){r.show=!0},buyProduct:a,routerToOrder:function(){t.push({path:"/order"})},handleClickMsg:function(){(0,Z.Toast)("请返回抖音联系客服")}})}};var Ne=r(830),Ee={insert:"head",singleton:!1};de()(Ne.Z,Ee);Ne.Z.locals;var Ve=r(307),Ce={insert:"head",singleton:!1};de()(Ve.Z,Ce);Ve.Z.locals;const Oe=(0,ve.Z)(ke,[["render",function(e,t,r,o,F,I){var Z=(0,n.resolveComponent)("van-icon"),G=(0,n.resolveComponent)("van-nav-bar"),R=(0,n.resolveComponent)("van-swipe-item"),M=(0,n.resolveComponent)("van-swipe"),A=(0,n.resolveComponent)("van-cell"),J=(0,n.resolveComponent)("ReplyItem"),U=(0,n.resolveComponent)("van-divider"),Y=(0,n.resolveComponent)("van-cell-group"),$=(0,n.resolveComponent)("Sku"),q=(0,n.resolveComponent)("van-button"),H=(0,n.resolveComponent)("van-skeleton");return(0,n.openBlock)(),(0,n.createElementBlock)("div",a,[(0,n.createVNode)(H,{row:20,loading:e.loading},{default:(0,n.withCtx)((function(){var r,a;return[(0,n.createVNode)(G,{fixed:"",placeholder:"","left-arrow":"",title:"商品详细",onClickLeft:t[0]||(t[0]=function(){})},{right:(0,n.withCtx)((function(){return[(0,n.createVNode)(Z,{onClick:o.routerToOrder,name:"cart-o",size:"18"},null,8,["onClick"])]})),_:1}),(0,n.createElementVNode)("div",c,[(0,n.createVNode)(M,{autoplay:3e3,"lazy-render":"",class:"product-image_swiper"},{default:(0,n.withCtx)((function(){return[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(e.data.images,(function(e,t){return(0,n.openBlock)(),(0,n.createBlock)(R,{key:t},{default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("img",{class:"product-image",src:"/storage/"+e.value},null,8,i)]})),_:2},1024)})),128))]})),_:1})]),(0,n.createElementVNode)("div",u,[(0,n.createElementVNode)("div",s,[(0,n.createElementVNode)("div",l,[(0,n.createElementVNode)("div",d,[(0,n.createElementVNode)("div",p,[(0,n.createElementVNode)("span",f,[v,(0,n.createTextVNode)(" "+(0,n.toDisplayString)(e.data.price),1)]),e.data.origin_price?((0,n.openBlock)(),(0,n.createElementBlock)("div",h,[m,(0,n.createTextVNode)(" "+(0,n.toDisplayString)(e.data.origin_price),1)])):(0,n.createCommentVNode)("",!0)])]),(0,n.createElementVNode)("div",g,[(0,n.createElementVNode)("div",y," 已售"+(0,n.toDisplayString)(e.data.sales),1)])]),(0,n.createElementVNode)("div",b,(0,n.toDisplayString)(e.data.title),1)])]),(0,n.createElementVNode)("div",x,[(0,n.createElementVNode)("div",w,[(0,n.createVNode)(A,null,{title:(0,n.withCtx)((function(){var t;return[(0,n.createElementVNode)("strong",_,"商品评论 ("+(0,n.toDisplayString)((null===(t=e.data)||void 0===t?void 0:t.replies_count)||0)+")",1)]})),value:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",{onClick:t[1]||(t[1]=function(t){return e.$router.push({path:"/replies",query:{id:e.data.id}})})},[k,(0,n.createVNode)(Z,{name:"arrow"})])]})),_:1}),(0,n.createElementVNode)("div",N,[null!==(r=e.data)&&void 0!==r&&null!==(a=r.replies)&&void 0!==a&&a.length?((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,{key:0},(0,n.renderList)(e.data.replies,(function(e){return(0,n.openBlock)(),(0,n.createBlock)(J,{key:e.id,reply:e},null,8,["reply"])})),128)):((0,n.openBlock)(),(0,n.createElementBlock)("div",E," 暂无评论 "))])])]),o.img?((0,n.openBlock)(),(0,n.createElementBlock)("div",V,[(0,n.createElementVNode)("div",{class:"product_info-border",onClick:t[2]||(t[2]=function(t){return e.$router.push({path:"/"})})},[(0,n.createElementVNode)("img",{src:o.img,alt:"",class:"mc-img"},null,8,C)])])):(0,n.createCommentVNode)("",!0),(0,n.createElementVNode)("div",O,[(0,n.createVNode)(U),j,(0,n.createVNode)(Y,{inset:""},{default:(0,n.withCtx)((function(){return[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(e.data.attributes,(function(e,t){return(0,n.openBlock)(),(0,n.createBlock)(A,{key:t,title:t,value:e},null,8,["title","value"])})),128))]})),_:1}),(0,n.createElementVNode)("div",S,[(0,n.createElementVNode)("div",{innerHTML:e.data.description},null,8,B)])]),(0,n.createVNode)($,{onBuy:o.buyProduct,product:e.data,show:e.show,"onUpdate:show":t[3]||(t[3]=function(t){return e.show=t})},null,8,["onBuy","product","show"]),(0,n.createElementVNode)("div",P,[(0,n.createElementVNode)("div",{class:"product_actions_icon",onClick:t[4]||(t[4]=function(t){return e.$router.push({path:"/"})})},[(0,n.createVNode)(Z,{size:"20",color:"#ee0a24",name:"shop-o"}),L]),(0,n.createElementVNode)("div",{class:"product_actions_icon",onClick:t[5]||(t[5]=function(){return o.handleClickMsg&&o.handleClickMsg.apply(o,arguments)})},[(0,n.createVNode)(Z,{size:"20",color:"#ee0a24",name:"chat-o"}),z]),(0,n.createElementVNode)("div",{class:"product_actions_icon",onClick:t[6]||(t[6]=function(t){return e.like=!e.like})},[(0,n.createVNode)(Z,{size:"20",color:e.like?"#ED0829":"#ee0a24",name:e.like?"star":"star-o"},null,8,["color","name"]),D]),(0,n.createVNode)(q,{class:"product_actions-button",onClick:o.showSku,round:"",size:"large",color:"linear-gradient(to right, #ff6034, #ee0a24)"},{default:(0,n.withCtx)((function(){return[T]})),_:1},8,["onClick"])])]})),_:1},8,["loading"])])}],["__scopeId","data-v-340403b2"]])}}]);