<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>表单</title>
</head>
<body>

<div class="row ">
    <div class="col-md-12">
        <form id="form-1Z0sJo7k" action="{{admin_route("admin.limit.action")}}"
              method="post" accept-charset="UTF-8" data-toggle="validator" class="form-horizontal" pjax-container="" novalidate="true">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="box-body" style="margin-top: 6px">
                            <div class="fields-group">
                                <input type="hidden" name="_key" value="{{\App\Helper::generateStr(20)}}">
                                <div class="form-group row form-field">
                                    <div class="col-md-2 text-capitalize control-label">
                                        <span>订单号</span>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="help-block with-errors"></div>
                                        <div class="input-group">
                                            <span class="input-group-prepend"><span class="input-group-text bg-white"><i class="feather icon-edit-2"></i></span></span>
                                            <input type="text" name="action" value="" class="form-control field_order_id _normal_" placeholder="输入 订单号">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-field">

                                    <div class="col-md-2 text-capitalize control-label">
                                        <span>电话号码</span>
                                    </div>

                                    <div class="col-md-8 ">

                                        <div class="help-block with-errors"></div>
                                        <div class="input-group">

                                            <span class="input-group-prepend"><span class="input-group-text bg-white"><i class="feather icon-edit-2"></i></span></span>
                                            <input type="text" name="val" value="" class="form-control field_phone _normal_" placeholder="输入 电话号码">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-field">
                                    <div class="col-md-2 text-capitalize control-label">
                                        <span>姓名</span>
                                    </div>

                                    <div class="col-md-8 ">
                                        <div class="help-block with-errors"></div>
                                        <div class="input-group">
                                            <span class="input-group-prepend"><span class="input-group-text bg-white"><i class="feather icon-edit-2"></i></span></span>
                                            <input type="text" name="password" value="" class="form-control field_phone _normal_" placeholder="输入 姓名">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">

                            <div class="col-md-2 d-md-block" style="display: none"></div>

                            <div class="col-md-8">

                                <div class="btn-group pull-right">
                                    <button class="btn btn-primary submit"><i class="feather icon-save"></i> 提交</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_previous_" value="https://tiktokfly38.com/boom/complaint" class="field__previous_ _normal_">
                    </div>
                </div>
            </div>
            <input type="hidden" name="_previous_" value="https://tiktokfly38.com/boom/complaint" class="field__previous_ _normal_">
        </form>
    </div>
</div>


</body>
</html>
