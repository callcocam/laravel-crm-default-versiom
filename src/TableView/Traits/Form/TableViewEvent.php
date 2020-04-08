<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Form;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;

trait TableViewEvent
{

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Set the Event Dispatcher to fire Laravel events.
     *
     * @param EventDispatcher $eventDispatcher
     * @return $this
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }
}
