<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use SIGA\Http\Requests\SubMenuRequest;

use SIGA\Submenu;

class SubMenuController extends AbstractController
{

    protected $model = Submenu::class;

    public function update(SubMenuRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(SubMenuRequest $request)
    {
       return parent::save($request);
    }
}
