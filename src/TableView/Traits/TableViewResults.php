<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

trait TableViewResults
{

    protected $results = [];

    public function getResults(){

        return $this->results;
    }

    public function getResult($key){
        if(isset($this->results[$key]))
            return $this->results[$key];

        return $key;
    }


    public function setResults($results=[]){

        $this->results = array_merge($this->data()->toArray(), $results);

        return $this;
    }

    /**
     * @return array|null
     */
    private function alias(){

        $alias=null;
        foreach ($this->columns() as $column) {
            if(!in_array($column->get('field'), $this->exclude)){
                if(!empty($column->get('refer'))){
                    $alias[] = $column->get('refer');
                }else{
                    $alias[] = $column->get('alias');
                }
            }
        }
        if($alias)
            return $alias;

        return ["*"];
    }

    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function data()
    {
        if ($this->hasPagination()) {
            $params = [];
            if ($this->appendsQueries) {
                if (is_array($this->appendsQueries)) {
                    $params = App::make('request')->query->get($this->appendsQueries);
                } else {
                    $params = App::make('request')->query->all();
                }
            }

            return $this->paginator->appends($params)->setPath('');
        }

        $this->applySearchFilter();

        return $this->builder->get();
    }

    /**
     *
     */
    private function applySearchFilter()
    {
        if (count($this->searchableFields()) && ! empty($this->searchQuery())) {
            if ($this->builder) {
                $keyword = strtolower($this->searchQuery());
                $this->builder->where(function ($query) use ($keyword) {
                    foreach ($this->searchableFields() as $field) {
                        $query->orWhere($field, 'LIKE', "%$keyword%");
                    }
                });
                // dd($this->builder->toSql());
            }
        }
    }

    /**
     * @return array
     */
    public function searchableFields()
    {
        return $this->searchFields;
    }

    /**
     * @return mixed
     */
    public function searchQuery()
    {
        return Request::get('q');
    }

    /**
     * @return bool
     */
    public function hasPagination()
    {
        return (bool) $this->paginator;
    }
}
