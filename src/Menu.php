<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use Illuminate\Database\Eloquent\Model;
use SIGA\TableView\DataViewsColumns;

class Menu extends Model
{
    public $incrementing = false;

    protected $keyType = "string";

    use  TraitTable;

    protected $fillable = [
        'company_id', 'user_id','title','name', 'path', 'url', 'auth', 'icone','ordering','description','created_at','updated_at'
    ];
    public function init(DataViewsColumns $dataViewsColumns)
    {
        $dataViewsColumns->text("title");
        $dataViewsColumns->column("name");
        $dataViewsColumns->column("path");
       // $dataViewsColumns->column("auth");
        $dataViewsColumns->column("icone");
        $dataViewsColumns->column("ordering");
        $dataViewsColumns->column("description");
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
