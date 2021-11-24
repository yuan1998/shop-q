<?php

use Dcat\Admin\OperationLog\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('operation-log', Controllers\OperationLogController::class.'@index');