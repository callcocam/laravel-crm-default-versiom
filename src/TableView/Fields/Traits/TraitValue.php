<?php


namespace SIGA\TableView\Fields\Traits;


use Illuminate\Support\Arr;

trait TraitValue
{
    /**
     * Name of the property for value setting.
     *
     * @var string
     */
    protected $valueProperty = 'value';

    /**
     * Name of the property for default value.
     *
     * @var string
     */
    protected $defaultValueProperty = 'default_value';

    /**
     * Is default value set?
     *
     * @var bool|false
     */
    protected $hasDefault = false;

    /**
     * @var \Closure|null
     */
    protected $valueClosure = null;
    /**
     * Setup the value of the form field.
     *
     * @return void
     */
    protected function setupValue()
    {
        $value = $this->getOption($this->valueProperty);
        $isChild = $this->getOption('is_child');

        if ($value instanceof \Closure) {
            $this->valueClosure = $value;
        }

        if (($value === null || $value instanceof \Closure) && !$isChild) {
            $this->setValue($this->getModelValueAttribute($this->parent->getModel(), $this->name));
        } elseif (!$isChild) {
            $this->hasDefault = true;
        }
    }


    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        if ($this->hasDefault) {
            return $this;
        }

        $closure = $this->valueClosure;

        if ($closure instanceof \Closure) {
            $value = $closure($value ?: null);
        }

        if (!$this->isValidValue($value)) {
            $value = $this->getOption($this->defaultValueProperty);
        }

        $this->options[$this->valueProperty] = $value;

        return $this;
    }


    /**
     * Get the attribute value from the model by name.
     *
     * @param mixed $model
     * @param string $name
     * @return mixed
     */
    protected function getModelValueAttribute($model, $name)
    {
        $transformedName = $this->transformKey($name);
        if (is_string($model)) {
            return $model;
        } elseif (is_object($model)) {
            return object_get($model, $transformedName);
        } elseif (is_array($model)) {
            return Arr::get($model, $transformedName);
        }
    }


    /**
     * Check if provided value is valid for this type.
     *
     * @return bool
     */
    protected function isValidValue($value)
    {
        return $value !== null;
    }


    /**
     * Get value property.
     *
     * @param mixed|null $default
     * @return mixed
     */
    public function getValue($default = null)
    {
        return $this->getOption($this->valueProperty, $default);
    }


    /**
     * Get default value property.
     *
     * @param mixed|null $default
     * @return mixed
     */
    public function getDefaultValue($default = null)
    {
        return $this->getOption($this->defaultValueProperty, $default);
    }


    /**
     * Return the extra render data for this form field, passed into the field's template directly.
     *
     * @return array
     */
    protected function getRenderData()
    {
        return [];
    }
}
