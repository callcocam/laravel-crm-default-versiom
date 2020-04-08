<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;

use SIGA\TableView\TableViewForm;
use SIGA\TraitTable;

trait Update
{


    /**
     * @param $id
     * @param string $template
     * @return \Illuminate\Support\HtmlString
     */
    public function edit($id, $template="edit"){

        $this->queryParams = request()->query();

        $this->setSubmit();

        $this->getSources();

        $this->source->where($this->getKeyName(), $id);
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


    public function updateBy($input,$id){
        array_push($this->fillable,'updated_at');
        /**
         * @var $model TraitTable
         */
        $this->model = $this->find($id);

        if(!$this->model):
            return $this->setMessages(false,'update');
        endif;
        unset($input['created_at']);
        $this->model->fill($input);
        if(!$this->model->save()):
            return $this->setMessages(false,'update');
        endif;
        $input = array_merge($input, $this->model->toArray());
        $this->lastId =  $id;
        $this->results['data'] =  $input;
        $this->results['id'] =  $id;
        return $this->setMessages(true,'update');
    }

}
