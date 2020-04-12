<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use Illuminate\Database\Eloquent\Model;
use SIGA\TableView\DataViewsColumns;

class Skill  extends Model
{
    use TraitTable;

    public $incrementing = false;

    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'company_id','name','slug','status','description','created_at','updated_at'
    ];

    public function init(DataViewsColumns $dataViewsColumns)
    {
        $this->setDefaultOption("title","List skill");

        $dataViewsColumns->text('name')->sorter(true);

        $dataViewsColumns->status('status','Status')->sorter(true);

        $dataViewsColumns->closure('updated_at', function ($model) {
            return date_carbom_format($model->users_updated_at)->toFormattedDateString();
        })->default_value(date("d/m/Y"))->hidden_list(true);

        $dataViewsColumns->closure('created_at', function ($model) {
            return date_carbom_format($model->users_created_at)->toDateString();
        })->default_value(date("d/m/Y"))->hidden_list(true);

        if ($this->tableView){
        
            $this->tableView->setSearchableFields(['name']);

        }


    }

    public function initFilter($query)
    {

    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
}
