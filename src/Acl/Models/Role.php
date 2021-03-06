<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */
namespace SIGA\Acl\Models;

use SIGA\TableView\DataViewsColumns;
use SIGA\TraitTable;
use Illuminate\Database\Eloquent\Model;
use SIGA\Acl\Concerns\HasPermissions;
use SIGA\Acl\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SIGA\Activitylog\Traits\LogsActivity;

class Role extends Model implements RoleContract
{
    use HasPermissions,TraitTable, LogsActivity;

    protected static $logAttribute = ['name', 'slug'];

    public $incrementing = false;

    protected $keyType = "string";

    protected $appends = ['link'];
    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['id','name', 'slug','description', 'special', 'status'];

    protected $casts = [
        'created_at'=>'date:d/m/Y',
        'updated_at'=>'date:d/m/Y',
    ];
    /**
     * Create a new Role instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('acl.tables.roles'));
    }

    /**
     * Roles can belong to many users.
     *
     * @return Model
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.model') ?: config('auth.providers.users.model'))->withTimestamps();
    }

    /**
     * Determine if role has permission flags.
     *
     * @return bool
     */
    public function hasPermissionFlags(): bool
    {
        return ! is_null($this->special);
    }
    /**
     * Determine if the requested permission is permitted or denied
     * through a special role flag.
     *
     * @return bool
     */
    public function hasPermissionThroughFlag(): bool
    {
        if ($this->hasPermissionFlags()) {
            return ! ($this->special === 'no-access');
        }
        return true;
    }


    public function init(DataViewsColumns $dataViewsColumns)
    {
        $this->setDefaultOption("title","List Roles");

        $dataViewsColumns->column("name")->sorter(true);

        $dataViewsColumns->column("special")->choices([
            ''=>"Acesso Controlado",
            'all-access'=>"Acesso Total",
            'no-access'=>"Nenhum Acesso",
        ])->expanded(true);


        $dataViewsColumns->view("permissions")
            ->entity(Permission::class)
            ->property("description")
            ->expanded(true)
            ->multiple(true)->hidden_list(true);
        $dataViewsColumns->status("status");

          $dataViewsColumns->text('description')->hidden_list(true);
        if($this->tableView){
            $this->tableView->childDetails(function ($data) {
                return view('laravel-form-builder::partials.permission',['data' => $data->permissions ]); // return view or string
            });
            $this->tableView->setExcludeFields(['permissions']);
            $this->tableView->setSearchableFields(['name']);
        }

    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
