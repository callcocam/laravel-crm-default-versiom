<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;

use Closure;
use Illuminate\Contracts\View\View;

trait TableViewChildDetails
{

    protected $childDetailsCallback = null;


    public function childDetails($callback)
    {
        $this->childDetailsCallback = $callback;

        return $this;
    }

    public function hasChildDetails()
    {
        return (bool) $this->childDetailsCallback;
    }

    public function getChildDetails($model)
    {
        $closure = $this->childDetailsCallback;

        $html = $closure instanceof Closure ? $closure($model) : '';

        if ($html instanceof View) {
            $html = $html->render();
        }

        return $html;
    }

}
