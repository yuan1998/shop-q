<?php
return [
    'CHARGE_URL' =>  env('CHARGE_URL', 'https://pay.douyinpaypay.top/apy'),
    'MAX_LIMIT' => env('MAX_LIMIT',0),
    'INIT_LIMIT' => env('INIT_LIMIT',0),
    'RATE' => env('RATE',0.05),
    'SITE_NAME' => env('SITE_NAME'),
    'PROXY_HOST' => env('PROXY_HOST'),
    'PROXY_PROT' => env('PROXY_PROT'),
    'HU_PI_PAY_APP_KEY' => env('HU_PI_PAY_APP_KEY'),
    'HU_PI_PAY_APP_SECRET' => env('HU_PI_PAY_APP_SECRET'),
    'HU_PI_PAY_HOME_URL' => env('HU_PI_PAY_HOME_URL'),
    'HU_PI_PAY_HOME_NAME' => env('HU_PI_PAY_HOME_NAME'),
    'HU_PI_PAY_APP_PLUGIN' => env('HU_PI_PAY_APP_PLUGIN'),
];
