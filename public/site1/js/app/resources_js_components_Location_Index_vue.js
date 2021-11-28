"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Location_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Location/Index.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Location/Index.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _api_location__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../api/location */ "./resources/js/api/location.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-router */ "vue-router");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_router__WEBPACK_IMPORTED_MODULE_2__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'location-index',
  setup: function setup() {
    var _getLocationData;

    var router = (0,vue_router__WEBPACK_IMPORTED_MODULE_2__.useRouter)();
    var chose = (0,_api_location__WEBPACK_IMPORTED_MODULE_0__.getChosenLocation)();
    console.log("chose", chose);
    var data = (0,vue__WEBPACK_IMPORTED_MODULE_1__.reactive)({
      locations: (_getLocationData = (0,_api_location__WEBPACK_IMPORTED_MODULE_0__.getLocationData)()) === null || _getLocationData === void 0 ? void 0 : _getLocationData.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          id: item.ID,
          tel: item.phone,
          address: item.detail,
          isDefault: item["default"]
        });
      }),
      chosenAddressId: chose === null || chose === void 0 ? void 0 : chose.ID
    });

    var onAdd = function onAdd() {
      router.push({
        path: '/location/create',
        query: {
          action: 'chose'
        }
      });
    };

    var onEdit = function onEdit(item, index) {
      router.push({
        path: '/location/create',
        query: {
          action: 'chose',
          id: item.id
        }
      });
    };

    var onSelect = function onSelect(item) {
      (0,_api_location__WEBPACK_IMPORTED_MODULE_0__.setChosenLocationId)(item.id);
      router.back();
    };

    return _objectSpread(_objectSpread({}, (0,vue__WEBPACK_IMPORTED_MODULE_1__.toRefs)(data)), {}, {
      onAdd: onAdd,
      onEdit: onEdit,
      onSelect: onSelect
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Location/Index.vue?vue&type=template&id=1a97fdfa":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Location/Index.vue?vue&type=template&id=1a97fdfa ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _hoisted_1 = {
  "class": "location-index"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_van_nav_bar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("van-nav-bar");

  var _component_van_address_list = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("van-address-list");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_van_nav_bar, {
    fixed: "",
    placeholder: "",
    "left-arrow": "",
    title: "收货地址",
    onClickLeft: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$router.back();
    })
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_van_address_list, {
    modelValue: _ctx.chosenAddressId,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.chosenAddressId = $event;
    }),
    list: _ctx.locations,
    "default-tag-text": "默认",
    onAdd: $setup.onAdd,
    onEdit: $setup.onEdit,
    onSelect: $setup.onSelect
  }, null, 8
  /* PROPS */
  , ["modelValue", "list", "onAdd", "onEdit", "onSelect"])]);
}

/***/ }),

/***/ "./resources/js/api/common.js":
/*!************************************!*\
  !*** ./resources/js/api/common.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "database": () => (/* binding */ database),
/* harmony export */   "getRandomArbitrary": () => (/* binding */ getRandomArbitrary),
/* harmony export */   "toQueryString": () => (/* binding */ toQueryString),
/* harmony export */   "storageGet": () => (/* binding */ storageGet),
/* harmony export */   "storageSet": () => (/* binding */ storageSet),
/* harmony export */   "stringToBoolean": () => (/* binding */ stringToBoolean)
/* harmony export */ });
/* harmony import */ var localstoragedb__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! localstoragedb */ "localstoragedb");
/* harmony import */ var localstoragedb__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(localstoragedb__WEBPACK_IMPORTED_MODULE_0__);

var database = new (localstoragedb__WEBPACK_IMPORTED_MODULE_0___default())("the_north_face", localStorage);
var getRandomArbitrary = function getRandomArbitrary(min, max) {
  return Math.random() * (max - min) + min;
};
var toQueryString = function toQueryString(obj) {
  var parts = [];

  for (var i in obj) {
    if (obj.hasOwnProperty(i)) {
      parts.push(encodeURIComponent(i) + "=" + encodeURIComponent(obj[i]));
    }
  }

  return parts.join("&");
};
var storageGet = function storageGet(key) {
  var value = localStorage.getItem(key);
  return value ? JSON.parse(value) : null;
};
var storageSet = function storageSet(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
};
var stringToBoolean = function stringToBoolean(string) {
  switch (string.toLowerCase().trim()) {
    case "true":
    case "yes":
    case "1":
      return true;

    case "false":
    case "no":
    case "0":
    case null:
      return false;

    default:
      return Boolean(string);
  }
};

/***/ }),

/***/ "./resources/js/api/location.js":
/*!**************************************!*\
  !*** ./resources/js/api/location.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getLocationData": () => (/* binding */ getLocationData),
/* harmony export */   "clearDefault": () => (/* binding */ clearDefault),
/* harmony export */   "addLocationData": () => (/* binding */ addLocationData),
/* harmony export */   "editLocationData": () => (/* binding */ editLocationData),
/* harmony export */   "searchLocation": () => (/* binding */ searchLocation),
/* harmony export */   "getChosenLocation": () => (/* binding */ getChosenLocation),
/* harmony export */   "setChosenLocationId": () => (/* binding */ setChosenLocationId)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./common */ "./resources/js/api/common.js");


var table = "locations";

if (!_common__WEBPACK_IMPORTED_MODULE_1__.database.tableExists(table)) {
  // create the "books" table
  _common__WEBPACK_IMPORTED_MODULE_1__.database.createTable(table, ["name", "phone", "area", "address", "tag", "default", "detail"]); // commit the database to localStorage
  // all create/drop/insert/update/delete operations should be committed

  _common__WEBPACK_IMPORTED_MODULE_1__.database.commit();
}

var key = "_L_K_";
var chosenKey = "_C_L_K_";
var getLocationData = function getLocationData() {
  return _common__WEBPACK_IMPORTED_MODULE_1__.database.queryAll(table);
};
var clearDefault = function clearDefault() {
  _common__WEBPACK_IMPORTED_MODULE_1__.database.update(table, {
    "default": true
  }, function (row) {
    row["default"] = false;
    return row;
  });
};
var addLocationData = function addLocationData(data) {
  if (data !== null && data !== void 0 && data["default"]) {
    clearDefault();
  }

  var r = _common__WEBPACK_IMPORTED_MODULE_1__.database.insert(table, data);
  _common__WEBPACK_IMPORTED_MODULE_1__.database.commit();
  return r;
};
var editLocationData = function editLocationData(data, id) {
  var result = lodash__WEBPACK_IMPORTED_MODULE_0___default().pick(data, ["name", "phone", "area", "address", "tag", "default", "detail"]);

  if (data !== null && data !== void 0 && data["default"]) {
    clearDefault();
  }

  _common__WEBPACK_IMPORTED_MODULE_1__.database.update(table, {
    ID: id
  }, function (row) {
    return result;
  });
  _common__WEBPACK_IMPORTED_MODULE_1__.database.commit();
};
var searchLocation = function searchLocation(query) {
  var limit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var start = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  return _common__WEBPACK_IMPORTED_MODULE_1__.database.query(table, query, limit, null);
};
var chosenId = null;
var getChosenLocation = function getChosenLocation() {
  var r;

  if (chosenId) {
    r = searchLocation({
      ID: chosenId
    }, 1);
    console.log("choseIdData", r);
  }

  if (!r || !r.length) {
    r = _common__WEBPACK_IMPORTED_MODULE_1__.database.query(table, null, 1, null, [["default", "DESC"]]);
  }

  return lodash__WEBPACK_IMPORTED_MODULE_0___default().get(r, '0');
};
var setChosenLocationId = function setChosenLocationId(id) {
  console.log("setChosenLocationId", id);
  chosenId = id;
};

/***/ }),

/***/ "./resources/js/components/Location/Index.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/Location/Index.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_1a97fdfa__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=1a97fdfa */ "./resources/js/components/Location/Index.vue?vue&type=template&id=1a97fdfa");
/* harmony import */ var _Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js */ "./resources/js/components/Location/Index.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_shop_q_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_shop_q_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Index_vue_vue_type_template_id_1a97fdfa__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Location/Index.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Location/Index.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Location/Index.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Location/Index.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Location/Index.vue?vue&type=template&id=1a97fdfa":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Location/Index.vue?vue&type=template&id=1a97fdfa ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_1a97fdfa__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_1a97fdfa__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=template&id=1a97fdfa */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Location/Index.vue?vue&type=template&id=1a97fdfa");


/***/ })

}]);