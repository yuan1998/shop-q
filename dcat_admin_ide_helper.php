<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection sortable
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection attributes
     * @property Grid\Column|Collection skus
     * @property Grid\Column|Collection image
     * @property Grid\Column|Collection url
     * @property Grid\Column|Collection add_type
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection comment
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection wechat
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection computed
     * @property Grid\Column|Collection custom_info
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection logistic_number
     * @property Grid\Column|Collection origin_price
     * @property Grid\Column|Collection pay_channel_id
     * @property Grid\Column|Collection pay_date
     * @property Grid\Column|Collection pay_info
     * @property Grid\Column|Collection pay_method
     * @property Grid\Column|Collection product_id
     * @property Grid\Column|Collection product_sku
     * @property Grid\Column|Collection return_at
     * @property Grid\Column|Collection return_location
     * @property Grid\Column|Collection return_logistics_number
     * @property Grid\Column|Collection return_reason
     * @property Grid\Column|Collection return_status
     * @property Grid\Column|Collection send_at
     * @property Grid\Column|Collection snapshot
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection alipay_enable
     * @property Grid\Column|Collection api_url
     * @property Grid\Column|Collection app_key
     * @property Grid\Column|Collection app_secret
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection images
     * @property Grid\Column|Collection rating
     * @property Grid\Column|Collection thumb
     * @property Grid\Column|Collection attribute_id
     * @property Grid\Column|Collection sales
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection merchantId
     * @property Grid\Column|Collection orderStatus
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection sortable(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection attributes(string $label = null)
     * @method Grid\Column|Collection skus(string $label = null)
     * @method Grid\Column|Collection image(string $label = null)
     * @method Grid\Column|Collection url(string $label = null)
     * @method Grid\Column|Collection add_type(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection comment(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection wechat(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection computed(string $label = null)
     * @method Grid\Column|Collection custom_info(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection logistic_number(string $label = null)
     * @method Grid\Column|Collection origin_price(string $label = null)
     * @method Grid\Column|Collection pay_channel_id(string $label = null)
     * @method Grid\Column|Collection pay_date(string $label = null)
     * @method Grid\Column|Collection pay_info(string $label = null)
     * @method Grid\Column|Collection pay_method(string $label = null)
     * @method Grid\Column|Collection product_id(string $label = null)
     * @method Grid\Column|Collection product_sku(string $label = null)
     * @method Grid\Column|Collection return_at(string $label = null)
     * @method Grid\Column|Collection return_location(string $label = null)
     * @method Grid\Column|Collection return_logistics_number(string $label = null)
     * @method Grid\Column|Collection return_reason(string $label = null)
     * @method Grid\Column|Collection return_status(string $label = null)
     * @method Grid\Column|Collection send_at(string $label = null)
     * @method Grid\Column|Collection snapshot(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection alipay_enable(string $label = null)
     * @method Grid\Column|Collection api_url(string $label = null)
     * @method Grid\Column|Collection app_key(string $label = null)
     * @method Grid\Column|Collection app_secret(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection images(string $label = null)
     * @method Grid\Column|Collection rating(string $label = null)
     * @method Grid\Column|Collection thumb(string $label = null)
     * @method Grid\Column|Collection attribute_id(string $label = null)
     * @method Grid\Column|Collection sales(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection merchantId(string $label = null)
     * @method Grid\Column|Collection orderStatus(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection sortable
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection username
     * @property Show\Field|Collection attributes
     * @property Show\Field|Collection skus
     * @property Show\Field|Collection image
     * @property Show\Field|Collection url
     * @property Show\Field|Collection add_type
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection price
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection comment
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection wechat
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection computed
     * @property Show\Field|Collection custom_info
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection logistic_number
     * @property Show\Field|Collection origin_price
     * @property Show\Field|Collection pay_channel_id
     * @property Show\Field|Collection pay_date
     * @property Show\Field|Collection pay_info
     * @property Show\Field|Collection pay_method
     * @property Show\Field|Collection product_id
     * @property Show\Field|Collection product_sku
     * @property Show\Field|Collection return_at
     * @property Show\Field|Collection return_location
     * @property Show\Field|Collection return_logistics_number
     * @property Show\Field|Collection return_reason
     * @property Show\Field|Collection return_status
     * @property Show\Field|Collection send_at
     * @property Show\Field|Collection snapshot
     * @property Show\Field|Collection status
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection alipay_enable
     * @property Show\Field|Collection api_url
     * @property Show\Field|Collection app_key
     * @property Show\Field|Collection app_secret
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection images
     * @property Show\Field|Collection rating
     * @property Show\Field|Collection thumb
     * @property Show\Field|Collection attribute_id
     * @property Show\Field|Collection sales
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection merchantId
     * @property Show\Field|Collection orderStatus
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection sortable(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection attributes(string $label = null)
     * @method Show\Field|Collection skus(string $label = null)
     * @method Show\Field|Collection image(string $label = null)
     * @method Show\Field|Collection url(string $label = null)
     * @method Show\Field|Collection add_type(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection comment(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection wechat(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection computed(string $label = null)
     * @method Show\Field|Collection custom_info(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection logistic_number(string $label = null)
     * @method Show\Field|Collection origin_price(string $label = null)
     * @method Show\Field|Collection pay_channel_id(string $label = null)
     * @method Show\Field|Collection pay_date(string $label = null)
     * @method Show\Field|Collection pay_info(string $label = null)
     * @method Show\Field|Collection pay_method(string $label = null)
     * @method Show\Field|Collection product_id(string $label = null)
     * @method Show\Field|Collection product_sku(string $label = null)
     * @method Show\Field|Collection return_at(string $label = null)
     * @method Show\Field|Collection return_location(string $label = null)
     * @method Show\Field|Collection return_logistics_number(string $label = null)
     * @method Show\Field|Collection return_reason(string $label = null)
     * @method Show\Field|Collection return_status(string $label = null)
     * @method Show\Field|Collection send_at(string $label = null)
     * @method Show\Field|Collection snapshot(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection alipay_enable(string $label = null)
     * @method Show\Field|Collection api_url(string $label = null)
     * @method Show\Field|Collection app_key(string $label = null)
     * @method Show\Field|Collection app_secret(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection images(string $label = null)
     * @method Show\Field|Collection rating(string $label = null)
     * @method Show\Field|Collection thumb(string $label = null)
     * @method Show\Field|Collection attribute_id(string $label = null)
     * @method Show\Field|Collection sales(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection merchantId(string $label = null)
     * @method Show\Field|Collection orderStatus(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
