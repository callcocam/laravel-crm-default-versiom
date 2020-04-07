<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use SIGA\Acl\Models\Role;
use SIGA\Http\Requests\RoleRequest;

class RoleController extends AbstractController
{

    protected $model = Role::class;

    public function update(RoleRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(RoleRequest $request)
    {
       return parent::save($request);
    }
}
