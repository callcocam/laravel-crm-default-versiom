<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use SIGA\Activitylog\Models\Activity;
use SIGA\Forms\ProfileForm;
use SIGA\Http\Requests\UserRequest;
use SIGA\TableView\TableViewFormBuilder;
use SIGA\User;

class ProfileController extends AbstractController
{

    protected $model = User::class;

    public function store(UserRequest $request)
    {
        $this->redirectRoute = "admin.profile.index";
        
        return parent::save($request, $request->get('id'));
    }

    public function profile(TableViewFormBuilder $tableViewFormBuilder){


        $user = User::find(Auth::id());

        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'PUT',
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
            'method' => 'PUT',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.personal-information', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function accountInformation(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'PUT',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.account-information', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function changePassword(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'PUT',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.change-password', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function emailSettings(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'PUT',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.email-settings', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }

    public function credCards(TableViewFormBuilder $tableViewFormBuilder){


        $form = $tableViewFormBuilder->create(ProfileForm::class, [
            'method' => 'PUT',
            'url' => route('admin.profile.store')
        ]);

        return view('admin.user.cred-cards', [
            'user'=>Auth::user(),
            'form'=>$form
        ]);
    }
}
