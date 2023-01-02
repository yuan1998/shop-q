<button type="button" class="account-limit btn btn-secondary"
        data-toggle="tooltip"
        data-placement="bottom"
        data-html="true"
        title="最小下限{{$maxLimit}},余额低于该数值将无法继续使用.<a href='{{admin_route("admin.account.charge.view")}}'>去充值</a>">
    账户余额: {{$count}}
</button>

<script init=".account-limit">
    $this.tooltip();
</script>
