<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Form;

use Cron\AbstractField;
use SIGA\TableView\DataViewFormHelper;
use SIGA\TableView\TableViewForm;
use Illuminate\Support\Arr;
use SIGA\TableView\Filters\FilterResolver;

trait TableViewfilterFields
{

    /**
     * To filter and mutate request values or not.
     *
     * @var bool
     */
    protected $lockFiltering = false;

    /**
     * Method filterFields used as *Main* method for starting
     * filtering and request field mutating process.
     *
     * @return TableViewForm
     */
    public function filterFields()
    {
        // If filtering is unlocked/allowed we can start with filtering process.
        if (!$this->isFilteringLocked()) {
            $filters = array_filter($this->getFilters());
              dd($filters);
            if (count($filters)) {
                $dotForm = $this->getNameKey();

                $request = $this->getRequest();
                $requestData = $request->all();

                foreach ($filters as $field => $fieldFilters) {
                    $dotField = $this->formHelper->transformToDotSyntax($field);
                    $fieldData = Arr::get($requestData, $dotField);
                    dd($fieldData);
                    if ($fieldData !== null) {
                        // Assign current Raw/Unmutated value from request.
                        $localDotField = preg_replace('#^' . preg_quote("$dotForm.", '#') . '#', '', $dotField);
                        $localBracketField = $this->formHelper->transformToBracketSyntax($localDotField);
                        $this->getField($localBracketField)->setRawValue($fieldData);
                        foreach ($fieldFilters as $filter) {
                            $filterObj = FilterResolver::instance($filter);
                            $fieldData = $filterObj->filter($fieldData);
                        }
                        Arr::set($requestData, $dotField, $fieldData);
                    }
                }

                foreach ($requestData as $name => $value) {
                    $request[$name] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Method getFilters used to return array of all binded filters to form fields.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = [];
        foreach ($this->getFields() as $field) {
            $filters[$field->getName()] = $field->getFilters();
        }

        return $filters;
    }

    /**
     * If lockFiltering is set to true then we will not
     * filter fields and mutate request data binded to fields.
     *
     * @return TableViewForm
     */
    public function lockFiltering()
    {
        $this->lockFiltering = true;
        return $this;
    }

    /**
     * Unlock fields filtering/mutating.
     *
     * @return TableViewForm
     */
    public function unlockFiltering()
    {
        $this->lockFiltering = false;
        return $this;
    }

    /**
     * Method isFilteringLocked used to check
     * if current filteringLocked property status is set to true.
     *
     * @return bool
     */
    public function isFilteringLocked()
    {
        return !$this->lockFiltering ? false : true;
    }

    /**
     * Get all fields.
     *
     * @return AbstractField
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Add multiple peices of data at once.
     *
     * @deprecated deprecated since 1.6.12, will be removed in 1.7 - use 3rd param on create, or 2nd on plain method to pass data
     * will be switched to protected in 1.7.
     * @param $data
     * @return $this
     **/
    public function addData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setData($key, $value);
        }

        return $this;
    }

    /**
     * Set the form helper only on first instantiation.
     *
     * @param DataViewFormHelper $formHelper
     * @return $this
     */
    public function setFormHelper(DataViewFormHelper $formHelper)
    {
        $this->formHelper = $formHelper;

        return $this;
    }

    /**
     * Add any aditional data that field needs (ex. array of choices).
     *
     * @deprecated deprecated since 1.6.20, will be removed in 1.7 - use 3rd param on create, or 2nd on plain method to pass data
     * will be switched to protected in 1.7.
     * @param string $name
     * @param mixed $data
     */
    public function setData($name, $data)
    {
       
        $this->data[$name] = $data;
    }

    /**
     * Get field dynamically.
     *
     * @param string $name
     * @return AbstractField
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->getField($name);
        }
    }

    /**
     * Check if field exists when fetched using magic methods.
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }
    /**
     * Returns and checks the type of the field.
     *
     * @param string $type
     * @return string
     */
    protected function getFieldType($type)
    {
        $fieldType = $this->formHelper->getFieldType($type);

        return $fieldType;
    }


    /**
     * Get single field instance from form object.
     *
     * @param string $name
     * @return FormField
     */
    public function getField($name)
    {
        if ($this->has($name)) {
            return $this->fields[$name];
        }

        $this->fieldDoesNotExist($name);
    }

    /**
     * Throw an exception indicating a field does not exist on the class.
     *
     * @param string $name
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function fieldDoesNotExist($name)
    {
        throw new \InvalidArgumentException('Field ['.$name.'] does not exist in '.get_class($this));
    }
}
