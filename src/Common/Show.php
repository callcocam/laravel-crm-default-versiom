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

trait Show
{


    public function findShow($id,$template="index"){


        $this->queryParams = request()->query();

        $this->setSubmit();

        $this->getSources();

        if($id){
            $this->source->where($this->getKeyName(), $id);
        }
        /**
         * @var TableView $tableView
         */
        $this->tableView = tableView($this->source);

        $tableViewColumns = tableViewColumns($this->source);

        $tableViewColumns->hidden($this->getKeyName())->hidden_list(true);

        $this->init($tableViewColumns);

        $this->tableView->setColumns($tableViewColumns->columns());

        $this->tableView->setDefaultOptions($this->defaultOptions);

        return $this->tableView->render($template);
    }
    /**
     * @param $key
     * @param array $params
     * @return mixed
     */
    public function getShow($key, $params=[])
    {

        $Create = $this->addShow($params);

        return $Create[$key];

    }

    public function addShow($params=[]){
        if(empty($this->getKey())){

            $key = $this->getResultLastId();
        }
        else{
            $key = $this->getKey();
        }
        try{
            return array_merge([
                'api' => route(sprintf(config('siga.table.admin.show.route','admin.%s.show'), $this->getTable()), array_merge([$this->getKeyName()=>$key], request()->all())),
                'name' => sprintf(config('siga.table.admin.show.route','admin.%s.show'), $this->getTable()),
                'id' => $key,
                'object' => [
                    'name' => sprintf(config('siga.table.admin.show.route','admin.%s.show'), $this->getTable()),
                    'params'=>[
                        $this->getKeyName()=>$key
                    ],
                    'query' => request()->query(),
                ],
                'icon' =>config('siga.table.admin.show.icon',"EyeIcon"),
                'function' => config('siga.table.admin.show.function',"showRecord"),
                'sgClass' => config('siga.table.admin.show.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
            ], $params);
        }catch (\Exception $exception){
            return [
                'api' => route(sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),  request()->query())
            ];
        }
    }

}
