<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SIGA\Http\Requests\UserRequest;
use SIGA\User;

class UserController extends AbstractController
{

    protected $model = User::class;

    public function update(UserRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(UserRequest $request)
    {
       return parent::save($request);
    }

    public function profile(UserRequest $request){

          //$user= User::query()->where('email','admin@localhost.crm-04.test')->where('password','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')->get();
         return view('admin.user.profile', [
            'user'=>Auth::user()
        ]);
    }
}
