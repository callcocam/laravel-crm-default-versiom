<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;


use Illuminate\Database\Eloquent\Model;
use SIGA\TableView\DataViewsColumns;

class Company extends Model
{
    public $incrementing = false;

    protected $keyType = "string";

    use  TraitTable;

    protected $fillable = [
        'id','company_id', 'user_id','name', 'email', 'phone', 'document','updated_at',
    ];
    public function init(DataViewsColumns $dataViewsColumns)
    {
        $this->setDefaultOption("title","Lista de companies");
       // $tableView->column('id')->format('hidden');
        $dataViewsColumns->column('name');
        $dataViewsColumns->column('email');
        $dataViewsColumns->column('phone');

        if ($this->tableView){
        
            $this->tableView->setSearchableFields(['name','email']);
        }

    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
