<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*
Route::prefix('v1')
    ->middleware('auth:api')
    ->namespace('API')
    ->group( function ($router) {

        $router->prefix('admin')->group( function ($router) {
            \SIGA\AutoRoute::get("languages","AdminController","language","admin.languages");
            \SIGA\AutoRoute::resources("users","UserController","users");
            \SIGA\AutoRoute::resources("companies","CompanyController","companies");
            \SIGA\AutoRoute::resources("users","UserController","users");
            \SIGA\AutoRoute::resources("roles","RoleController","roles");
            \SIGA\AutoRoute::resources("permissions","PermissionController","permissions");
            \SIGA\AutoRoute::resources("menus","MenuController","menus");
        });

    });
*/
