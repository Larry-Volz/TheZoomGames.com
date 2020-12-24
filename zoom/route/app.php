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
use think\facade\Route;

Route::get('/', 'Index/index');
Route::get('test', 'index/test');
Route::post('getUser', 'Index/getUser');
Route::post('setName', 'Index/setName');
Route::post('match', 'Index/match');
Route::get('queryLangs', 'Index/queryLangs');
Route::get('requestToken', 'Index/requestToken');
Route::get('refreshToken', 'Index/refreshToken');
Route::get('createMeeting', 'Index/createMeeting');
Route::post('joinMeeting', 'Index/joinMeeting');
