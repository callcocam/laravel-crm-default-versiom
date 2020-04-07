<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;


trait TableViewFilters
{

    protected $queryParams =[];

    protected $filters = [];

    /**
     * @param $filter
     * @param array $options
     */
    public function addFilters($filter, $options=[]){

        $this->filters[$filter] = $options;
    }

    /**
     * @return int
     */
    public function hasFilters(){

        return count($this->filters);

    }

    /**
     * @return mixed
     */
    public function getFilters(){

        return $this->filters;

    }

    /**
     * @param $key
     * @param $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFilter($key, $options){

        return view($this->getConfig($key))->with('tableView' , $this)->with('options' , $options)->render();

    }

    /**
     * @param $queryParams
     * @return TableViewFilters
     */
    public function addQueryParams($queryParams){

        $this->queryParams = $queryParams;

        return $this->initFilters();
    }

    /**
     * @return $this
     */
    protected function initFilters(){

        $this->addFilters("search", [
            'name'=>"q",
            "value"=>$this->params('q','')
        ]);


        $this->addFilters("date", [
            'name'=>"date",
            'start'=>$this->params('start',''),
            'end'=>$this->params('end',''),
        ]);

        $this->addFilters("status", [
            'name'=>"status",
            "value"=>$this->params('status','all'),
            'options'=>[
                'all'=>"Tudo",
                'published'=>"Ativo",
                'draft'=>"Inativo",
            ]
        ]);

        $this->addFilters("items-page", [
            'name'=>"perPage",
            "value"=>$this->params('perPage',12),
            'options'=>[6,12,24,48,95]
        ]);

        return $this;
    }


    /**
     * @param $key
     * @param null $default
     * @return |null
     */
    protected function params($key, $default=null){

        if(isset($this->queryParams[$key]))
            return $this->queryParams[$key];

        return $default;
    }
}
