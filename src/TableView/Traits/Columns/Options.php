<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Columns;

trait Options
{

    /**
     * @param string $valueProperty
     * @return $this
     */
    public function propertyValue($valueProperty="value")
    {

        $this->valueProperty = $valueProperty;

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {

        $this->render['type'] = $type;

        return $this;
    }

    /**
     * @param $sorter
     * @return $this
     */
    public function sorter($sorter)
    {
        $this->render['sorter'] = $sorter;

        return $this;
    }

    /**
     * @param $width
     * @return $this
     */
    public function width($width)
    {
        $this->render['width'] = $width;

        return $this;
    }
    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {

        foreach ($options as $key => $option){

            $this->option($key, $option);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $attribute
     * @return $this
     */
    public function default_value($default_value)
    {
        $this->render['default_value'] = $default_value;

        return $this;
    }

    /**
     * @param $key
     * @param $attribute
     * @return $this
     */
    public function attribute($key, $attribute)
    {
        $this->render['attributes'][$key] = $attribute;

        return $this;
    }


    /**
     * @param array $options
     * @return $this
     */
    public function attributes(array $attributes)
    {
        foreach ($attributes as $key => $attribute){

            $this->attribute($key, $attributes);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $option
     * @return $this
     */
    public function option($key, $option)
    {
        $this->render['options'][$key] = $option;

        return $this;
    }

    /**
     * @param $classes
     * @return $this
     */
    public function classes($classes)
    {
        $this->render['classes'] = $classes;

        return $this;
    }

}
