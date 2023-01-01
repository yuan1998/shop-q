<h3 style="margin-top: 20px;">
    账户余额(最大欠费{{$maxLimit}})
</h3>
<div class="input-group sm-3">
    <input type="text" class="form-control" value="{{$count}}" disabled>
    <div class="input-group-append">
        <a href="{{admin_route("admin.account.limit.charge")}}" target="_blank" class="btn btn-outline-secondary btn-primary" type="button">充值</a>
    </div>
</div>
