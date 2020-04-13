<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView;


use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use SIGA\TableView\Traits\TableViewActions;
use SIGA\TableView\Traits\TableViewAttributes;
use SIGA\TableView\Traits\TableViewChildDetails;
use SIGA\TableView\Traits\TableViewFilters;
use SIGA\TableView\Traits\TableViewOptions;
use SIGA\TableView\Traits\TableViewResults;
use SIGA\TableView\Traits\TableViewRoutes;
use SIGA\TableView\Traits\TableViewTypes;

class TableView implements Htmlable
{
    use TableViewFilters,
        TableViewChildDetails,
        TableViewResults,
        TableViewActions,
        TableViewAttributes,
        TableViewTypes,
        TableViewOptions,
        TableViewRoutes;

    use Macroable {
        __call as macroCall;
    }

    protected $id;


    protected $form;
    protected $exclude = [];
    protected $config = [];
    protected $columns = [];
    protected $table = null;

    /** @var Builder */
    protected $builder;



    public function __construct($builder)
    {

        $this->config = config('laravel-form-builder');

        if ($builder instanceof Builder) {
            $this->builder = $builder;
        }

        $this->table = $this->getModel()->getTable();

    }


    /**
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return $this
     */
    public function paginate($perPage = 15, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $this->applySearchFilter();

        $this->paginator = $this->builder->paginate($perPage, $this->alias(), 'page', $page);

        return $this;
    }



    /**
     * @param array $forgings
     * @return TableView
     */
    public function forgings(array $forgings): TableView
    {

        if($forgings){

            foreach ($forgings as $forging) {

                $this->builder->leftJoin(
                    $forging['on'],
                    sprintf( '%s.%s',$forging['on'],$forging['references']),
                    '=',
                    sprintf( '%s.%s',$this->getModel()->getTable(),$forging['field'])
                );
                $this->inner($forging['on']);

                foreach ($forging['columns'] as $column) {

                    $this->column($column)->hidden_list(true);
                }
            }
        }

        $this->inner($this->getModel()->getTable());

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function inner($table)
    {
        $this->table = $table;

        return $this;
    }


    /**
     * @param array $fields
     * @return $this
     */
    public function setSearchableFields($fields = [])
    {
        $this->searchFields = $fields;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setExcludeFields($fields = [])
    {
        $this->exclude = $fields;

        return $this;
    }


    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param bool $append
     * @return $this
     */
    public function appendsQueries($append = true)
    {
        $this->appendsQueries = $append;

        return $this;
    }


    /**
     * @return array
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * @return array
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }


    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }

    public function render($template = null)
    {
        $this->id = 'table-'.Str::random(6);

        $this->setResults();
        return view($this->getConfig($template))
            ->with('tableView', $this)->render();
    }




    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->builder->getModel();
    }
}
