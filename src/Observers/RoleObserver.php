<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Observers;

use SIGA\Acl\Models\Role;
use SIGA\Http\Requests\RoleRequest;

class RoleObserver
{
    /**
     * @var RoleRequest
     */
    private $roleRequest;

    /**
     * RoleObserver constructor.
     * @param RoleRequest $roleRequest
     */
    public function __construct(RoleRequest $roleRequest)
    {

        $this->roleRequest = $roleRequest;
    }

    /**
     * Handle the role "created" event.
     *
     * @param  Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        if($this->roleRequest->has('permissions')){
            $role->permissions()->sync($this->roleRequest->get("permissions"));
        }
    }

    /**
     * Handle the role "updated" event.
     *
     * @param  Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        if($this->roleRequest->has('permissions')){
            $role->permissions()->sync($this->roleRequest->get("permissions"));
        }
    }

    /**
     * Handle the role "deleted" event.
     *
     * @param  Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        dd($role);
    }

    /**
     * Handle the role "restored" event.
     *
     * @param  Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        dd($role);
    }

    /**
     * Handle the role "force deleted" event.
     *
     * @param  Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
