<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::get('/', 'index/index/index');
Route::get('/redis', 'index/index/index2');
Route::post('/kill', 'index/kill/kill');
Route::post('/redis_kill', 'index/kill/redis_kill');
Route::get('/order', 'index/order/index');