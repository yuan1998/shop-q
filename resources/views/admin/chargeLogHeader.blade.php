<h3 style="margin-top: 20px;">
    账户余额{{$count}}(最大欠费{{$maxLimit}})
</h3>
<form action="{{admin_route("admin.account.limit.charge")}}" method="post">
    <div class="input-group sm-3">
        <input type="number" class="form-control" required na   me="price" placeholder="输入充值金额" min="500">
        <div class="input-group-append">
            <button type="submit" class="btn btn-outline-secondary btn-primary" >充值</button>
        </div>
    </div>
</form>
