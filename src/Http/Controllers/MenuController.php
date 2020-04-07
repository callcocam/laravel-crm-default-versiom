<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use SIGA\Http\Requests\MenuRequest;
use SIGA\Menu;

class MenuController extends AbstractController
{

    protected $model = Menu::class;

    public function update(MenuRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(MenuRequest $request)
    {
       return parent::save($request);
    }
}
