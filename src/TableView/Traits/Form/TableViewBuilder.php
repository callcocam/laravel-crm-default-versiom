<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Form;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use SIGA\TableView\TableViewFormBuilder;

trait TableViewBuilder
{
    /**
     * @var TableViewFormBuilder
     */
    protected $formBuilder;
    /**
     * Set form builder instance on helper so we can use it later.
     *
     * @param TableViewFormBuilder $formBuilder
     * @return $this
     */
    public function setFormBuilder(TableViewFormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;

        return $this;
    }

}
