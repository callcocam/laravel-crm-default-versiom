<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;



use Illuminate\Support\Facades\Gate;

trait TableViewActions
{

    /**
     * @return bool
     */
    public function hasActions()
    {
        return true;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCreate()
    {
        if (Gate::allows(sprintf('admin.%s.create', $this->getEndpoint()))) {
            return view($this->getConfig("partials_buttons_create"), [
                'data' => $this->builder->getModel()->addCreate()
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addIndex()
    {
        if (Gate::allows(sprintf('admin.%s.index', $this->getEndpoint()))) {
            return view($this->getConfig("partials_buttons_index"), [
                'data'=>$this->builder->getModel()->addIndex()
            ]);
        }

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addReload()
    {
        if (Gate::allows(sprintf('admin.%s.index', $this->getEndpoint()))) {
            return view($this->getConfig("partials_buttons_index"), [
                'data' => $this->builder->getModel()->addReload()
            ]);
        }
    }

    /**
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actions($model)
    {
        $actions = [];

        if (Gate::allows(sprintf('admin.%s.edit', $this->getEndpoint()))) {

            $actions['edit'] = $model->addEdit();
        }

        if (Gate::allows(sprintf('admin.%s.edit', $this->getEndpoint()))) {

            $actions['show'] = $model->addShow();

        }

        if (Gate::allows(sprintf('admin.%s.edit', $this->getEndpoint()))) {

            $actions['destroy'] = $model->addDestroy();

        }

        return view($this->getConfig("partials_buttons_actions"), $actions);
    }

}
