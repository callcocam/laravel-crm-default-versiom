<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Columns;

trait Entity
{

    protected $appendOptionsEntity = [];

    public function entity($entity, $property = "name", $property_key = null, $query_builder=null)
    {
        $this->appendOptionsEntity['class'] = $entity;

        $this->property($property);

        $this ->type('entity');

        $this->property_key($property_key);

        $this->query_builder($query_builder);

        $this->propertyValue("selected");

        return $this;
    }

    public function property($property)
    {

        $this->appendOptionsEntity['property'] =$property;

        return $this;
    }

    public function property_key($property_key)
    {

        $this->appendOptionsEntity['property_key'] =$property_key;

        return $this;
    }

    public function query_builder($query_builder)
    {

        $this->appendOptionsEntity['query_builder'] =$query_builder;

        return $this;
    }


}
