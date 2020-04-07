<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;


trait Routes
{

    /**
     * @param $key
     * @param array $params
     * @return mixed
     */
    public function getEdit($key, $params=[])
    {

        $Create = $this->addEdit($params);

        return $Create[$key];

    }
    public function addEdit($params=[]){

        if(empty($this->getKey())){

            $key = $this->getResultLastId();
        }
        else{
            $key = $this->getKey();
        }
        try{
            return array_merge([
                'api' => route(sprintf(config('siga.table.admin.edit.route','admin.%s.edit'), $this->getTable()), array_merge([$this->getKeyName()=>$key], request()->query())),
                'query' => request()->query(),
                'name' => sprintf(config('siga.table.admin.edit.route','admin.%s.edit'), $this->getTable()),
                'object' => [
                    'name' => sprintf(config('siga.table.admin.edit.route','admin.%s.edit'), $this->getTable()),
                    'params'=>[
                        $this->getKeyName()=>$key
                    ],
                    'query' => request()->query(),
                ],
                'id' => $key,
                'icon' => config('siga.table.admin.edit.icon',"Edit3Icon"),
                'function' =>config('siga.table.admin.edit.function',"editRecord"),
                'sgClass' => config('siga.table.admin.edit.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
            ], $params);
        }catch (\Exception $exception){
            return [
                'api' => route(sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),  request()->query())
            ];
        }

    }
    /**
     * @param $key
     * @param array $params
     * @return mixed
     */
    public function getUpdate($key, $params=[])
    {

        $Update = $this->addUpdate($params);

        return $Update[$key];

    }

    public function addUpdate($params=[]){
        if(empty($this->getKey())){

            $key = $this->getResultLastId();
        }
        else{
            $key = $this->getKey();
        }

        try{
            return array_merge([
                'api' => route(sprintf(config('siga.table.admin.update.route','admin.%s.update'), $this->getTable()), array_merge([$this->getKeyName()=>$key], request()->all())),
                'name' => sprintf(config('siga.table.admin.update.route','admin.%s.update'), $this->getTable()),
                'id' => $key,
                'object' => [
                    'name' => sprintf(config('siga.table.admin.update.route','admin.%s.update'), $this->getTable()),
                    'params'=>[
                        $this->getKeyName()=>$key
                    ],
                    'query' => request()->query(),
                ],
                'icon' =>config('siga.table.admin.update.icon',"EyeIcon"),
                'function' => config('siga.table.admin.update.function',"updateRecord"),
                'sgClass' => config('siga.table.admin.update.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
            ], $params);
        }catch (\Exception $exception){
            return [
                'api' => route(sprintf(config('siga.table.admin.index.route','admin.%s.index'), $this->getTable()),  request()->query())
            ];
        }
    }


    /**
     * @param $key
     * @param array $params
     * @return mixed
     */
    public function getCreate($key, $params=[])
    {

        $Create = $this->addCreate($params);

        return $Create[$key];
    }

    /**
     * @param array $params
     * @return array
     */
    public function addCreate($params=[]){

        return array_merge([
            'api' => route(sprintf(config('siga.table.admin.create.route','admin.%s.create'), $this->getTable()), request()->query()),
            'query' => request()->query(),
            'name' => sprintf(config('siga.table.admin.create.route','admin.%s.create'), $this->getTable()),
            'object' => [
                'name' => sprintf(config('siga.table.admin.create.route','admin.%s.create'), $this->getTable()),
                'query' => request()->query(),
            ],
            'icon' => config('siga.table.admin.create.icon',"ListIcon"),
            'function' =>config('siga.table.admin.create.function',"addRecord"),
            'sgClass' => config('siga.table.admin.create.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }


    public function addDestroy($params=[]){
        if(empty($this->getKey())){

            $key = $this->getResultLastId();
        }
        else{
            $key = $this->getKey();
        }
        return array_merge([
            'api' => route(sprintf(config('siga.table.admin.destroy.route',"admin.%s.destroy"), $this->getTable()), array_merge([$this->getKeyName()=>$key], request()->query())),
            'name' => sprintf('admin.%s.destroy', $this->getTable()),
            'id' => $key,
            'object' => [
                'name' => sprintf(config('siga.table.admin.destroy.route',"admin.%s.destroy"), $this->getTable()),
                'params'=>[
                    $this->getKeyName()=>$key
                ],
                'query' => request()->query(),
            ],
            'icon' => config('siga.table.admin.destroy.icon',"Trash2Icon"),
            'function' => config('siga.table.admin.destroy.function',"confirmDeleteRecord"),
            'sgClass' => config('siga.table.admin.destroy.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }
}
