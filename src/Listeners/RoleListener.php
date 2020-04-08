<?php

namespace SIGA\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SIGA\Http\Requests\RoleRequest;

class RoleListener
{
    /**
     * @var RoleRequest
     */
    private $roleRequest;

    /**
     * Create the event listener.
     *
     * @param RoleRequest $roleRequest
     */
    public function __construct(RoleRequest $roleRequest)
    {
        //
        $this->roleRequest = $roleRequest;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if($this->roleRequest->has('permissions')){
             $event->role->permissions()->sync($this->roleRequest->get("permissions"));
        }
    }
}
