<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Filters\Exception;

class FilterAlreadyBindedException extends \Exception
{
    public function __construct($filter, $field)
    {
        $message = sprintf(
            'Filter with name: %filter already assigned for field: %field',
                $filter, $field
        );
        parent::__construct($message);
    }
}