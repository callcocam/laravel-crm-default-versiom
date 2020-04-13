<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SIGA\Acl\Models\Role;
use SIGA\Events\RoleEvent;

class RestrictController extends Controller
{

    protected $model = Role::class;

    protected $eventCreate = RoleEvent::class;

    protected $eventUpdate = RoleEvent::class;

    public function index()
    {
       return view("admin.restricts",[
           'user' => Auth::user()
       ]);
    }

}
