<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;

use SIGA\TableView\TableViewForm;

trait Create
{

    protected $errorsKeysCreate = [];


    /**
     * @param string $template
     * @return \Illuminate\Support\HtmlString
     */
    public function create($template="create"){

        $this->queryParams = request()->query();

        $this->setSubmit();

        $this->getSources();
        /**
         * @var TableViewForm $tableView
         */
        $this->formView = tableViewForm();

        $this->formView->setBuilder($this->source);

        $tableViewColumns = tableViewColumns($this->source);

        $tableViewColumns->hidden($this->getKeyName())->hidden_list(true);

        $this->init($tableViewColumns);

        $this->formView->setColumns($tableViewColumns->columns());

        $this->formView->setDefaultOptions($this->defaultOptions);

        return $this->formView->renderView($template);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function createBy($input)
    {
        array_push($this->fillable,'company_id','created_at','updated_at');

        unset($input['id']);

        $data = [];

        foreach ($this->fillable as $value) :

            try {
                $data[$value] = $input[$value];
            } catch (\Exception $e) { }

        endforeach;

        try {
            $this->model = self::query()->create($data);

        } catch (\Illuminate\Database\QueryException $e) {

            $this->messages = $e->getMessage();

            if ($this->errorsKeysCreate) {

                foreach ($this->errorsKeysCreate as $key => $value) {

                    if (\Str::contains($e->getMessage(), $key)) {

                        $this->messages[]  = $value;

                    }
                }
            }
            return $this->setMessages(false,'create');
        }

        if (!$this->model) :

            return $this->setMessages(false,'create');

        endif;

        $this->lastId = $this->model->id;

        $input = array_merge($input, $this->model->toArray());

        $this->results['data'] = $input;

        return $this->setMessages(true,'create');
    }


}
