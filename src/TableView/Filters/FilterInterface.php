<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Filters;

interface FilterInterface
{
    /**
     * Returns the result of filtering $value.
     *
     * @param  mixed $value
     * @param  array $options
     *
     * @throws \Exception If filtering $value is impossible.
     *
     * @return mixed
     */
    public function filter($value, $options = []);

    /**
     * Returns the filter name so we can use this as alias for easily
     * removing, adding filters.
     *
     * @return string
     */
    public function getName();
}