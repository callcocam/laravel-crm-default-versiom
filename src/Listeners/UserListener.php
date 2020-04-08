<?php

namespace SIGA\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SIGA\Http\Requests\UserRequest;

class UserListener
{
    /**
     * @var UserRequest
     */
    private $userRequest;

    /**
     * Create the event listener.
     *
     * @param UserRequest $userRequest
     */
    public function __construct(UserRequest $userRequest)
    {
        //
        $this->userRequest = $userRequest;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if($this->userRequest->has('roles')){
            $event->user->roles()->sync($this->userRequest->get("roles"));
        }
    }
}
