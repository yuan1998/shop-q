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
    </div>

    <div>
        <button type="submit">Pay</button>
    </div>
</form>

</body>
</html>
