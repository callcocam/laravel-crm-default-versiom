<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use Illuminate\Database\Eloquent\Model;
use SIGA\TableView\DataViewsColumns;

class File extends Model
{

    use TraitTable;

    public function init(DataViewsColumns $dataViewsColumns)
    {
        // TODO: Implement init() method.
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
