<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(["middleware"=>'auth','prefix'=>'admin'], function ($router) {

    \SIGA\AutoRoute::get("/","AdminController","index","admin");
    \SIGA\AutoRoute::get("/profile","UserController","profile","admin.profile.index");
    \SIGA\AutoRoute::post("/profile","UserController","profile","admin.profile.store");
    \SIGA\AutoRoute::resources("users","UserController","users");
    \SIGA\AutoRoute::resources("companies","CompanyController","companies");
    \SIGA\AutoRoute::resources("roles","RoleController","roles");
    \SIGA\AutoRoute::resources("permissions","PermissionController","permissions");
    \SIGA\AutoRoute::resources("menus","MenuController","menus");
    \SIGA\AutoRoute::resources("sub-menus","SubMenuController","submenus");

});
