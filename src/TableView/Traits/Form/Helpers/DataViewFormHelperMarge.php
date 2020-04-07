<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Form\Helpers;


use SIGA\TableView\Fields\AbstractField;
use SIGA\TableView\Rules;

trait DataViewFormHelperMarge
{


    /**
     * Merge options array.
     *
     * @param array $targetOptions
     * @param array $sourceOptions
     * @return array
     */
    public function mergeOptions(array $targetOptions, array $sourceOptions)
    {
        return array_replace_recursive($targetOptions, $sourceOptions);
    }

    /**
     * @param AbstractField[] $fields
     * @return array
     */
    public function mergeFieldsRules($fields)
    {
        $rules = new Rules([]);

        foreach ($fields as $field) {
            $rules->append($this->getFieldValidationRules($field));
        }

        return $rules;
    }

    /**
     * @param array $fields
     * @return array
     */
    public function mergeAttributes(array $fields)
    {
        $attributes = [];
        foreach ($fields as $field) {
            $attributes = array_merge($attributes, $field->getAllAttributes());
        }

        return $attributes;
    }


    /**
     * @param AbstractField $field
     * @return array
     */
    public function getFieldValidationRules(AbstractField $field)
    {
        $fieldRules = $field->getValidationRules();

        if (is_array($fieldRules)) {
            $fieldRules = Rules::fromArray($fieldRules)->setFieldName($field->getNameKey());
        }

        $formBuilder = $field->getParent()->getFormBuilder();
        $formBuilder->fireEvent(new AfterCollectingFieldRules($field, $fieldRules));

        return $fieldRules;
    }
}
