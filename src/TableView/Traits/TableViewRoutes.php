<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;



use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Gate;

trait TableViewRoutes
{


    /**
     * @return Factory|\Illuminate\View\View
     */
    public function routeCreate()
    {
        if (Gate::allows(sprintf('admin.%s.create', $this->getEndpoint()))) {
            return $this->builder->getModel()->getCreate('api');
        }
        return "admin";
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function routeIndex()
    {
        if (Gate::allows(sprintf('admin.%s.index', $this->getEndpoint()))) {
            return $this->builder->getModel()->getIndex('api');
        }

        return "admin";
    }


    /**
     * @return Factory|\Illuminate\View\View
     */
    public function routeReload()
    {
        if (Gate::allows(sprintf('admin.%s.index', $this->getEndpoint()))) {
            return $this->builder->getModel()->getReload('api');
        }
        return "admin";
    }

}
