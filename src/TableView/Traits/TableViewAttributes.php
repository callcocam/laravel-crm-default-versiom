<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;

use Closure;

trait TableViewAttributes
{


    protected $tableRowAttributes;
    protected $tableBodyClass;
    protected $classes = 'table';
    protected $title = 'Data List';
    protected $subtitle = 'Sub Title';

    /**
     * @param $title
     * @return TableViewAttributes
     */
    public function setTitle($title){

        $this->title= $title;

        return $this;
    }

    /**
     * @param $subtitle
     * @return TableViewAttributes
     */
    public function setSubtitle($subtitle){

        $this->subtitle = $subtitle;

        return $this;
    }


    /**
     * @return string
     */
    public function getTitle(){

        return $this->title;
    }

    /**
     * @return string
     */
    public function getSubtitle(){

      return  $this->subtitle;
    }

    public function setTableClass($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function getTableClass()
    {
        return $this->classes;
    }

    public function getTableRowAttributes($model = null)
    {
        if (is_array($this->tableRowAttributes)) {
            return $this->tableRowAttributes;
        }

        $closure = $this->tableRowAttributes;

        return $closure instanceof Closure ? $closure($model) : [];
    }

    public function setTableRowAttributes($data)
    {
        $this->tableRowAttributes = $data ?? [];

        return $this;
    }

    public function setTableBodyClass($class)
    {
        $this->tableBodyClass = $class;

        return $this;
    }

    public function geTableBodyClass()
    {
        return $this->tableBodyClass;
    }
}
