<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $role;

    /**
     * Create a new event instance.
     *
     * @param $role
     */
    public function __construct($role)
    {
        //
        $this->role = $role;
    }

}
