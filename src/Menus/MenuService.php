<?php


namespace App\Suports\Menus;


use Illuminate\Support\Facades\Route;

class MenuService
{

    protected $menus = [];

    /**
     * @return $this
     */
    public function parent(){

        $this->menus =$this->validate([
            [
                'cannot'=>['admin.companies.index'],
                'liClass'=>'nav-item',
                'aClass'=>'nav-item-hold',
                'iconClass'=>'nav-icon i-Gear-2',
                'route'=>'admin.companies.index',
                'label'=>"Configurações",
            ],
            [
                'cannot'=>['admin.roles.index','admin.permissions.index'],
                'liClass'=>'nav-item',
                'aClass'=>'nav-item-hold',
                'iconClass'=>'nav-icon i-Lock-User',
                'dataItem'=>'operacional',
                'href'=>'#',
                'label'=>"Operacional",
            ],
            [
                'cannot'=>['admin.users.index'],
                'liClass'=>'nav-item',
                'aClass'=>'nav-item-hold',
                'iconClass'=>'nav-icon i-Add-User',
                'route'=>'admin.users.index',
                'label'=>"Usuários",
            ],
        ]);
        return $this;
    }

    /**
     * @return MenuService
     */
    public function children(){

        $this->menus = [
            'operacional'=>[
                [
                    'liClass'=>'nav-item',
                    'aClass'=>'nav-item',
                    'iconClass'=>'nav-icon i-Arrow-Forward-2',
                    'route'=>'admin.permissions.index',
                    'label'=>"Permissões",
                ],
                [
                    'cannot'=>['admin.roles.index'],
                    'liClass'=>'nav-item',
                    'aClass'=>'nav-item-hold',
                    'iconClass'=>'nav-icon i-Arrow-Forward-2',
                    'route'=>'admin.roles.index',
                    'label'=>"Papéis",
                ]
            ],
        ];

        return $this;
    }

    public function render($template="parent"){

        return view(sprintf("vendor.menus.%s", $template), [
            'menus'=>$this->menus
        ])->render();
    }

    private function validate($menus){

        $data=[];

        if($menus):
            foreach ($menus as $key => $menu):
                if(isset($menu['route'])):
                    if(Route::has($menu['route'])):
                        $data[] = $menu;
                    endif;
                else:
                    $data[] = $menu;
                endif;
            endforeach;
        endif;
        return $data;
    }
}
