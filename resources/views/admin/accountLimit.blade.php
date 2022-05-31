<button type="button" class="account-limit btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="最小下限{{$maxLimit}},余额低于该数值将无法继续使用.">
    账户余额: {{$count}}
</button>


<script init=".account-limit">
    $this.tooltip();
</script>
