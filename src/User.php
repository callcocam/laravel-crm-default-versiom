<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use SIGA\Acl\Concerns\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SIGA\Acl\Models\Role;
use SIGA\Activitylog\Traits\LogsActivity;
use SIGA\TableView\DataViewsColumns;

class User  extends Authenticatable
{
 use TraitTable, HasRolesAndPermissions, Notifiable, LogsActivity;

    public $incrementing = false;

    protected $keyType = "string";

    protected static $logAttribute = ['name', 'slug','email','phone','document'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'company_id','name','slug',"fantasy",'email','phone','document','birthday','gender','password','is_admin','status','description','created_at','updated_at'
    ];

    
    public function init(DataViewsColumns $dataViewsColumns)
    {
        $this->setDefaultOption("title","Lista de users");

        $dataViewsColumns->text('name')->sorter(true);
        $dataViewsColumns->column('email')->sorter(true);
        $dataViewsColumns->column('phone')->hidden_list(true);
        $dataViewsColumns->view('roles')
            ->type('entity')
            ->entity(Role::class)
            ->expanded(true)
            ->multiple(true);

        $dataViewsColumns->status('status','Status')->sorter(true);

        $dataViewsColumns->closure('updated_at', function ($model) {
            return date_carbom_format($model->users_updated_at)->toFormattedDateString();
        })->default_value(date("d/m/Y"))->hidden_list(true);

        $dataViewsColumns->closure('created_at', function ($model) {
            return date_carbom_format($model->users_created_at)->toDateString();
        })->default_value(date("d/m/Y"))->hidden_list(true);

        if ($this->tableView){
            $this->tableView->childDetails(function ($data) {
                return view('partials.address',compact('data')); // return view or string
            });

            $this->tableView->setSearchableFields(['name','email']);

            $this->tableView->setExcludeFields(['roles']);
        }


    }

    public function initFilter($query)
    {

    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function education()
    {
        return $this->hasOne(Education::class);
    }
   
    public function educations()
    {
        return $this->hasMany(Education::class);
    }
   
    public function skill()
    {
        return $this->hasOne(Skill::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function address(){
        return $this->morphOne(Addres::class, 'addresable')->select(['zip','city','state','country', 'street','district','number','complement']);
    }

    public function getAddressAttribute(){

        return $this->address();
    }

}
