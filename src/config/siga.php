<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

return [
    "table"=>[
        'admin'=>[
            'index'=>[
                'icon'=> "fa fa-reply-all",
                'route'=> "admin.%s.index",
                'class'=>"btn btn-primary text-white",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Visualização dos registros carregado com sucesso!!",
                        'error'=>"Falhou, não foi possivel carregar os registros!!",
                    ],
                    'type'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ]
                ]
            ],
            'edit'=>[
                'icon'=> "Edit3Icon",
                'route'=> "admin.%s.edit",
                'class'=>"btn btn-primary text-white",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Realizada com sucesso, registro foi atualizado com sucesso!!",
                        'error'=>"Falhou, não foi possivel encontrar o registro - %s!!",
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'danger',
                    ]
                ]
            ],
            'update'=>[
                'icon'=> "Edit3Icon",
                'route'=> "admin.%s.update",
                'class'=>"btn btn-primary text-white",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Realizada com sucesso, registro foi atualizado com sucesso!!",
                        'error'=>"Falhou, não foi possivel encontrar o registro - %s!!",
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'primary',
                    ]
                ]
            ],
            'show'=>[
                'function'=> "showRecord",
                'icon'=> "EyeIcon",
                'route'=> "admin.%s.show",
                'class'=>"btn btn-primary text-white",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Registro encontrado com sucesso!!",
                        'error'=>"Falhou, não foi possivel encontrar o registro - %s!!",
                    ],
                    'type'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ]
                ]
            ],
            'create'=>[
                'function'=> "createRecord",
                'icon'=> "fa fa-plus",
                'route'=> "admin.%s.create",
                'class'=>"btn btn-primary text-white",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Realizada com sucesso, registro cadastrado com sucesso!!",
                        'error'=>"Falhou, não foi possivel cadastra um novo registro!!",
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'danger',
                    ]
                ]
            ],
            'destroy'=>[
                'function'=> "confirmDeleteRecord",
                'icon'=> "Trash2Icon",
                'route'=> "admin.%s.destroy",
                'class'=>"btn btn-primary text-white",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Realizada com sucesso, registro foi excluido com sucesso!!",
                        'error'=>"Falhou, não foi possivel encontrar o registro - %s!!",
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'danger',
                    ]
                ]
            ]
        ],
        'eloquent'=>[
            'filter'=>[
                'default_date'=>'created_at'
            ]
        ]
    ],
    "image"=>[
        'no_image'=>"/storage/default/no-image-available-grid.png",
        'no_avatar'=>"/storage/users/no_avatar-%s.jpg",
        'no_avatar_male'=>"/storage/users/no_avatar-male.jpg",
        'no_avatar_female'=>"/storage/users/no_avatar-female.jpg",
    ]
];
