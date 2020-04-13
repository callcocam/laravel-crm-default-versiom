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

    public function profile(TableViewFormBuilder $tableViewFormBuilder){


        $user = User::find(Auth::id());

        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'POST',
            'model' => $user,
            'url' => route('admin.profile.store')
        ], $user->toArray());
    
        $form->setFormOption('model',$user);
        return view('admin.user.profile', [
            'logs'=>Activity::all(),
            'user'=>$user,
            'form'=>$form
        ]);
    }

    public function personalInformation(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'POST',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.personal-information', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function accountInformation(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'POST',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.account-information', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function changePassword(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'POST',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.change-password', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function emailSettings(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'POST',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.email-settings', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function credCards(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'POST',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.cred-cards', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }
}
