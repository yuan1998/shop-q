<?php

use Dcat\Admin\GridSortable\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('extension/grid-sort', Controllers\GridSortableController::class.'@sort')->name('dcat-admin-grid-sortable');
