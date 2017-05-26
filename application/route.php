<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::get('/', 'index/index/index'); // 首页
Route::get('/page/:page', 'index/index/index'); // 首页分页路由
Route::get('/p/:id', 'index/index/article'); // 查看文章路由
Route::resource('/admin/article', 'admin/article'); // 添加后台文章资源路由
