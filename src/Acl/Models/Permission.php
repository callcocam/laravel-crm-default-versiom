<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */
namespace SIGA\Acl\Models;

use Illuminate\Support\Str;
use SIGA\Acl\Helper;
use SIGA\TableView\DataViewsColumns;
use SIGA\TraitTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SIGA\Acl\Concerns\RefreshesPermissionCache;
use SIGA\Acl\Contracts\Permission as PermissionContract;
use SIGA\Activitylog\Traits\LogsActivity;

class Permission extends Model implements PermissionContract
{
    use RefreshesPermissionCache,TraitTable, LogsActivity;
    
    protected static $logAttribute = ['name', 'slug'];
    /**
     * @var Helper
     */
    private $helper;

    public $incrementing = false;

    protected $keyType = "string";

    protected $appends = ['link'];
    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'groups', 'description', 'status','created_at','updated_at'];
    /**
     * Create a new Permission instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);


        $this->setTable(config('acl.tables.permissions'));
    }

    /**
     * Permissions can belong to many roles.
     *
     * @return Model
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('acl.models.role'))->withTimestamps();
    }


    public function init(DataViewsColumns $dataViewsColumns)
    {
        $this->setDefaultOption("title","List permissions");
        $this->addPermissions($dataViewsColumns);
        $dataViewsColumns->column("slug");
        $dataViewsColumns->status('status');

        if($this->tableView)
          $this->tableView->setSearchableFields(['name','slug']);

    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
    /**
     * @param $input
     * @return mixed
     */
    public function createBy($input)
    {
        if(empty($input['slug'])){

            $input['slug']= Str::slug($input['name'],'.');

        }
        return $this->finallyCreated($input);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function updateBy($input,$id)
    {
        if(empty($input['slug'])){

            $input['slug']= Str::slug($input['name'],'.');

        }
        return $this->finallyUpdateBy($input, $id);
    }

    protected function addPermissions(DataViewsColumns $dataViewsColumns){


        if($this->updatedId){
            $dataViewsColumns->column('name', 'text');

            return $dataViewsColumns;
        }
        $this->helper = new Helper($this);

        $model = $this->helper->getPermissions($this->getModel());

        if(!$model){

            $dataViewsColumns->column('name', 'text');
            return $dataViewsColumns;
        }

        $dataViewsColumns->column('name')->choices($model);
        return $dataViewsColumns;

    }
}
