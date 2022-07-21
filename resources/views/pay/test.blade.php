<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay Test</title>
</head>
<body>
<form action="/test_pay" method="post">
    <div>
        <label>
            金额
            <input type="number" name="amount" placeholder="输入金额" value="20">
        </label>
        <br>
        <label>
            支付通道Code
            <input type="number" name="code" placeholder="输入通道" value="1001">
        </label>
        <br>
    </div>

    <div>
        <button type="submit">Pay</button>
    </div>
</form>
<script>
    (function() {
        'use strict';
        function getQueryParams(qs) {
            qs = qs.split('+').join(' ');

            var params = {},
                tokens,
                re = /[?&]?([^=]+)=([^&]*)/g;

            while (tokens = re.exec(qs)) {
                params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
            }

            return params;
        }

        var query = getQueryParams(document.location.search);
        for (const [key ,value] of Object.entries(query)) {

            let el = document.querySelector(`[name=${key}]`);
            console.log("el",el);
            console.log("key",key,`[name=${key}]`);
            if (el) el.value = value;
        }
        console.log("query",query);
    })();
</script>
</body>
</html>
