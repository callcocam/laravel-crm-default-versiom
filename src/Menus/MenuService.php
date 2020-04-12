<?php


namespace SIGA\Menus;


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
                'aClass'=>'nav-link',
                'iconClass'=>'fas fa-cogs nav-icon',
                'route'=>'admin.companies.index',
                'label'=>"Configurações",
            ],
            [
                'cannot'=>['admin.users.index','admin.roles.index','admin.permissions.index'],
                'liClass'=>'nav-item',
                'aClass'=>'nav-link',
                'iconClass'=>'fas fa-user-lock nav-icon',
                'dataItem'=>'operacional',
                'href'=>'#',
                'label'=>"Operacional",
                'items'=>$this->children()
            ],
        ]);
        return $this;
    }

    /**
     * @return MenuService
     */
    public function children(){

       return [
            [
                'cannot'=>['admin.users.index'],
                'route'=>'admin.users.index',
                'liClass'=>'nav-item',
                'aClass'=>'nav-link',
                'iconClass'=>'far fa-circle nav-icon',
                'route'=>'admin.users.index',
                'label'=>"Users",
            ],
            [
                'cannot'=>['admin.permissions.index'],
                'liClass'=>'nav-item',
                'aClass'=>'nav-link',
                'iconClass'=>'far fa-circle nav-icon',
                'route'=>'admin.permissions.index',
                'label'=>"Permission",
            ],
            [
                'cannot'=>['admin.roles.index'],
                'liClass'=>'nav-item',
                'aClass'=>'nav-link',
                'iconClass'=>'far fa-circle nav-icon',
                'route'=>'admin.roles.index',
                'label'=>"Roles",
            ],
        ];
    }

    public function render($template="parent"){
        $menus=[];
        foreach ($this->menus as $menu):
            if(isset($menu['items'])):

                $menus[]= view("vendor.menus.has-treeview", [
                    'menus'=>$menu
                ])->render();
            else:
                $menus[]= view("vendor.menus.nav-item", [
                    'menus'=>$menu
                ])->render();
            endif;
        endforeach;
        return view(sprintf("vendor.menus.%s", $template), [
            'menus'=>implode(PHP_EOL, $menus)
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
