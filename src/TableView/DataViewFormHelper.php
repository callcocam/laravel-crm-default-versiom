<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\View\Factory as View;
use Illuminate\Support\Collection;
use SIGA\TableView\Fields\AbstractField;
use SIGA\TableView\Traits\Form\Helpers\DataViewFormHelperAttributes;
use SIGA\TableView\Traits\Form\Helpers\DataViewFormHelperMarge;

class DataViewFormHelper extends AbstractDataViewFormHelper
{
    use DataViewFormHelperMarge,DataViewFormHelperAttributes;


    /**
     * Custom types
     *
     * @var array
     */
    private $customTypes = [];

    /**
     * @var array
     */
    protected static $reservedFieldNames = [
        'save'
    ];
    /**
     * All available field types
     *
     * @var array
     */
    protected static $availableFieldTypes = [
        'text'           => 'InputType',
        'email'          => 'InputType',
        'url'            => 'InputType',
        'tel'            => 'InputType',
        'search'         => 'InputType',
        'password'       => 'InputType',
        'hidden'         => 'InputType',
        'number'         => 'InputType',
        'date'           => 'InputType',
        'file'           => 'InputType',
        'image'          => 'InputType',
        'color'          => 'InputType',
        'datetime-local' => 'InputType',
        'month'          => 'InputType',
        'range'          => 'InputType',
        'time'           => 'InputType',
        'week'           => 'InputType',
        'select'         => 'SelectType',
        'textarea'       => 'TextareaType',
        'button'         => 'ButtonType',
        'buttongroup'    => 'ButtonGroupType',
        'submit'         => 'ButtonType',
        'reset'          => 'ButtonType',
        'radio'          => 'CheckableType',
        'checkbox'       => 'CheckableType',
        'choice'         => 'ChoiceType',
        'form'           => 'ChildFormType',
        'entity'         => 'EntityType',
        'myentity'       => 'MyEntityType',
        'collection'     => 'CollectionType',
        'repeated'       => 'RepeatedType',
        'static'         => 'StaticType'
    ];

    /**
     * @param View    $view
     * @param Translator $translator
     * @param array   $config
     */
    public function __construct(View $view, Translator $translator, array $config = [])
    {
       parent::__construct($view,$translator,$config);

        $this->loadCustomTypes();
    }

    /**
     * Format the label to the proper format.
     *
     * @param $name
     * @return string
     */
    public function formatLabel($name)
    {
        if (!$name) {
            return null;
        }

        if ($this->translator->has($name)) {
            $translatedName = $this->translator->get($name);

            if (is_string($translatedName)) {
                return $translatedName;
            }
        }

        return ucfirst(str_replace('_', ' ', $name));
    }



    /**
     * Load custom field types from config file.
     */
    private function loadCustomTypes()
    {
        $customFields = (array) $this->getConfig('custom_fields');

        if (!empty($customFields)) {
            foreach ($customFields as $fieldName => $fieldClass) {
                $this->addCustomField($fieldName, $fieldClass);
            }
        }
    }

    /**
     * Get proper class for field type.
     *
     * @param $type
     * @return string
     */
    public function getFieldType($type)
    {
        $types = array_keys(static::$availableFieldTypes);

        if (!$type || trim($type) == '') {
            throw new \InvalidArgumentException('Field type must be provided.');
        }

        if ($this->hasCustomField($type)) {
            return $this->customTypes[$type];
        }

        if (!in_array($type, $types)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unsupported field type [%s]. Available types are: %s',
                    $type,
                    join(', ', array_merge($types, array_keys($this->customTypes)))
                )
            );
        }

        $namespace = __NAMESPACE__.'\\Fields\\';

        return $namespace . static::$availableFieldTypes[$type];
    }
    /**
     * @param string $key
     * @param string $default
     * @param array $customConfig
     * @return mixed
     */
    public function getConfig($key = null, $default = null, $customConfig = [])
    {
        $config = array_replace_recursive($this->config, $customConfig);

        if ($key) {
            return Arr::get($config, $key, $default);
        }

        return $config;
    }

    /**
     * Check if custom field with provided name exists
     * @param string $name
     * @return boolean
     */
    public function hasCustomField($name)
    {
        return array_key_exists($name, $this->customTypes);
    }

    /**
     * Add custom field.
     *
     * @param $name
     * @param $class
     * @return mixed
     */
    public function addCustomField($name, $class)
    {
        if (!$this->hasCustomField($name)) {
            return $this->customTypes[$name] = $class;
        }

        throw new \InvalidArgumentException('Custom field ['.$name.'] already exists on this form object.');
    }


    /**
     * Check if field name is valid and not reserved.
     *
     * @param string $name
     * @param string $className
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function checkFieldName($name, $className)
    {
        if (!$name || trim($name) == '') {
            throw new \InvalidArgumentException(
                "Please provide valid field name for class [{$className}]"
            );
        }

        if (in_array($name, static::$reservedFieldNames)) {
            throw new \InvalidArgumentException(
                "Field name [{$name}] in form [{$className}] is a reserved word. Please use a different field name." .
                "\nList of all reserved words: " . join(', ', static::$reservedFieldNames)
            );
        }

        return true;
    }


    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param object $model
     * @return object|null
     */
    public function convertModelToArray($model)
    {
        if (!$model) {
            return null;
        }

        if ($model instanceof Model) {
            return $model->toArray();
        }

        if ($model instanceof Collection) {
            return $model->all();
        }

        return $model;
    }


    /**
     * @param string $string
     * @return string
     */
    public function transformToDotSyntax($string)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $string);
    }

    /**
     * @param AbstractField $field
     * @return RulesParser
     */
    public function createRulesParser(AbstractField $field)
    {
        return new RulesParser($field);
    }
}
