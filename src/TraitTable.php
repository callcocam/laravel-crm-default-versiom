<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace SIGA;

use Illuminate\Database\Eloquent\SoftDeletes;
use SIGA\TableView\DataViewsColumns;
use SIGA\Tenant\BelongsToTenants;
use SIGA\Common\{Helper, Options, Routes, Show, Update, Create, Delete, Eloquent, Select};

trait TraitTable
{
    use Routes, Helper, Show,Options, Select,Eloquent,Create,Update,Delete, SoftDeletes,BelongsToTenants;

    protected $data = [];

    protected $model;

    protected $tableView;

    protected $formView;

    abstract public function init(DataViewsColumns $dataViewsColumns);

    abstract public function initFilter($query);

    public function getEndpoint(){

        return $this->getTable();
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

}
