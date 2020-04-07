<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;

use Illuminate\Database\Eloquent\Builder;
use SIGA\Company;
use SIGA\Processors\AvatarProcessor;
use SIGA\TableView\TableView;
use SIGA\User;
use SIGA\File;

trait Select
{


    public function findAll($template="index"){

        $this->queryParams = request()->query();

        $this->getSources();

        $forgings =  $this->innerJoin();

        $this->order();

        $this->initQuery();

        $this->initFilter($this->source);

        /**
         * @var TableView $tableView
         */
        $this->tableView = tableView($this->source);

        $tableViewColumns = tableViewColumns($this->source);

        $tableViewColumns->hidden($this->getKeyName())->hidden_list(true);

        $this->init($tableViewColumns);

        $this->tableView->setColumns($tableViewColumns->columns());

        $this->tableView->addQueryParams($this->paramsAll());

        $this->tableView->forgings($forgings);

        $this->tableView->appendsQueries(true);

        $this->tableView->paginate($this->params('perPage',12));

        $this->tableView->setDefaultOptions($this->defaultOptions);

        return $this->tableView->render($template);
    }

    public function author()
    {
        $user = $this->user()->first();
        if($user){
            $user->append('avatar');
            $user->append('created_mm_dd_yyyy');
        }
        return $user;
    }


    /**
     * @return mixed
     */
    public function getUserAttribute()
    {
        return $this->user();
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return File
     */
    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * @return mixed
     */
    public function getCompanyNameAttribute()
    {
        return $this->company_name();
    }

    /**
     * @return mixed
     */
    public function company_name()
    {
        if($this->company()->count())
           return $this->company()->first()->name;

        return \Auth::user()->company->name;
    }

    /**
     * @return mixed
     */
    public function getCompanyAttribute()
    {
        return $this->company();
    }

    /**
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function getLinkAttribute(){

        return [
            'edit'=>$this->addEdit(),
            'show'=>$this->addShow(),
            'destroy'=>$this->addDestroy(),
        ];
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getAvatarAttribute()
    {
        return AvatarProcessor::get($this);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getCoverAttribute()
    {
        return AvatarProcessor::get($this);
    }


    public function getStore($key,$params=[]){

        $store = $this->addStore($params);

        return $store[$key];
    }

    public function addStore($params=[]){

        return array_merge([
            'api' => route(sprintf(config('siga.table.admin.store.route','admin.%s.store'), $this->getTable()), request()->query()),
            'query' => request()->query(),
            'name' => sprintf(config('siga.table.admin.store.route','admin.%s.store'), $this->getTable()),
            'object' => [
                'name' => sprintf(config('siga.table.admin.store.route','admin.%s.store'), $this->getTable()),
                'query' => request()->query(),
            ]
        ], $params);
    }

    public function getIndex($key,$params=[]){

        $Index = $this->addIndex($params);

        return $Index[$key];
    }

    public function addIndex($params=[]){
        return array_merge([
            'api' => route(sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()), request()->query()),
            'query' => request()->query(),
            'name' => sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),
            'object' => [
                'name' => sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),
                'query' => request()->query(),
            ],
            'icon' => config('siga.table.admin.index.icon',"ListIcon"),
            'function' =>config('siga.table.admin.index.function',"addRecord"),
            'sgClass' => config('siga.table.admin.index.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }


    public function getReload($key,$params=[]){

        $Reload = $this->addReload($params);

        return $Reload[$key];
    }

    public function addReload($params=[]){
        return array_merge([
            'api' => route(sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable())),
            'query' => request()->query(),
            'name' => sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),
            'object' => [
                'name' => sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),
                'query' => request()->query(),
            ],
            'icon' => config('siga.table.admin.index.icon',"ListIcon"),
            'function' =>config('siga.table.admin.index.function',"addRecord"),
            'sgClass' => config('siga.table.admin.index.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }


}
