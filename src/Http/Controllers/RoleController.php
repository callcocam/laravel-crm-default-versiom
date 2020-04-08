<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use SIGA\Acl\Models\Role;
use SIGA\Events\RoleEvent;
use SIGA\Http\Requests\RoleRequest;

class RoleController extends AbstractController
{

    protected $model = Role::class;

    protected $eventCreate = RoleEvent::class;

    protected $eventUpdate = RoleEvent::class;

    public function update(RoleRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(RoleRequest $request)
    {
       return parent::save($request);
    }
}
