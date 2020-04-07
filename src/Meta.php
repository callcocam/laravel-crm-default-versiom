<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;


use Illuminate\Database\Eloquent\Model;
use SIGA\TableView\DataViewsColumns;

class Meta extends Model
{
    public $incrementing = false;

    protected $keyType = "string";

    use  TraitTable;

    protected $fillable = [
        'id','company_id', 'user_id','name', 'slug','description','updated_at'
    ];
    public function init(DataViewsColumns $dataViewsColumns)
    {
       // $tableView->column('id')->format('hidden');
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
