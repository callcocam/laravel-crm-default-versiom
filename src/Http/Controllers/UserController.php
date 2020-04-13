<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use SIGA\Activitylog\Models\Activity;
use SIGA\Events\UserEvent;
use SIGA\Forms\ProfileForm;
use SIGA\Http\Requests\UserRequest;
use SIGA\TableView\TableViewFormBuilder;
use SIGA\User;

class UserController extends AbstractController
{

    protected $model = User::class;

    protected $eventCreate = UserEvent::class;

    protected $eventUpdate = UserEvent::class;

    public function update(UserRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(UserRequest $request)
    {
        
       return parent::save($request);
    }

}
