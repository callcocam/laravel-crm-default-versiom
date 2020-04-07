<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use SIGA\Acl\Models\Permission;
use SIGA\Http\Requests\PermissionRequest;

class PermissionController extends AbstractController
{

    protected $model = Permission::class;

    public function update(PermissionRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(PermissionRequest $request)
    {
       return parent::save($request);
    }
}
