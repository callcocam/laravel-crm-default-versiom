<?php
/**
 * ==============================================================================================================
 *
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 * ==============================================================================================================
 */

namespace App\Suports\Menus;


use Illuminate\Support\Facades\Facade;

class AutoMenu extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'autoMenu';
    }
}
