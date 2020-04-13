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

\SIGA\AutoRoute::get("/acesso-negado","RestrictController","index","restricts");

Route::group(["middleware"=>'auth','prefix'=>'admin'], function ($router) {

    
    \SIGA\AutoRoute::get("/","AdminController","index","admin");

    \SIGA\AutoRoute::get("/profile","ProfileController","profile","admin.profile.index");
    \SIGA\AutoRoute::get("/personal-information","ProfileController","personalInformation","admin.personal-information.index");
    \SIGA\AutoRoute::get("/account-information","ProfileController","accountInformation","admin.account-information.index");
    \SIGA\AutoRoute::get("/change-password","ProfileController","changePassword","admin.change-password.index");
    \SIGA\AutoRoute::get("/email-settings","ProfileController","emailSettings","admin.email-settings.index");
    \SIGA\AutoRoute::get("/cred-cards","ProfileController","credCards","admin.cred-cards.index");
    \SIGA\AutoRoute::put("/profile","ProfileController","store","admin.profile.store");

    \SIGA\AutoRoute::resources("users","UserController","users");
    \SIGA\AutoRoute::resources("companies","CompanyController","companies");
    \SIGA\AutoRoute::resources("roles","RoleController","roles");
    \SIGA\AutoRoute::resources("permissions","PermissionController","permissions");
    \SIGA\AutoRoute::resources("menus","MenuController","menus");
    \SIGA\AutoRoute::resources("sub-menus","SubMenuController","submenus");

});
