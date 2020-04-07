<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use SIGA\TableView\Fields\AbstractField;
use SIGA\TableView\Traits\Form\TableViewValidation;
use SIGA\TableView\Traits\TableViewOptions;
use SIGA\TableView\Traits\TableViewResults;
use SIGA\TableView\Traits\TableViewRoutes;

class TableViewForm
{

    use TableViewValidation, TableViewOptions, TableViewRoutes,TableViewResults;

    protected $formOptions = [
        "method"=>"POST"
    ];
    /**
     * @var DataViewFormHelper
     */
    protected $formHelper;

    /**
     * @var tableViewFormBuilder
     */
    protected $formBuilder;

    protected $fields = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * Name of the parent form if any.
     *
     * @var string|null
     */
    protected $name = null;
    /**
     * List of fields to not render.
     *
     * @var array
     **/
    protected $exclude = [];

    /**
     * Model to use.
     *
     * @var mixed
     */
    protected $builder = [];


    /**
     * @var string
     */
    protected $templatePrefix;

    /**
     * @var string
     */
    protected $translationTemplate;

    /**
     * @var string
     */
    protected $languageName;

    protected $columns;

    protected $data;

    public function __construct($model)
    {
        $this->builder = $model;
        $this->formHelper = app()->get('laravel-form-helper');
        $this->config = $this->formHelper->getConfig();

    }

    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */

    /**
     * @return array
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * @return array
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Create a new field and add it to the form.
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     * @param bool   $modify
     * @return $this
     */
    public function add($name, $type = 'text', array $options = [], $modify = false)
    {
        $this->formHelper->checkFieldName($name, get_class($this));

        $this->addField($this->makeField($name, $type, $options), $modify);

        return $this;
    }

    /**
     * Returns the name of the form.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Check if form has field.
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->fields);
    }

    /**
     * @param array $formOptions
     * @return TableViewForm
     */
    public function setFormOptions(array $formOptions): TableViewForm
    {
        $this->formOptions = array_merge($this->formOptions, $formOptions);

        return $this;
    }

    /**
     * Returns the instance of the FormBuilder.
     *
     * @return tableViewFormBuilder
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }
    /**
     * @return array
     */
    public function getFormOptions(): array
    {
        return $this->formOptions;
    }

    /**
     * Get single form option.
     *
     * @param string $option
     * @param mixed|null $default
     * @return mixed
     */
    public function getFormOption($option, $default = null)
    {
        return Arr::get($this->formOptions, $option, $default);
    }
    /**
     * Set single form option on form.
     *
     * @param string $option
     * @param mixed $value
     *
     * @return $this
     */
    public function setFormOption($option, $value)
    {
        $this->formOptions[$option] = $value;

        return $this;
    }


    /**
     * Get template prefix that is prepended to all template paths.
     *
     * @return string
     */
    public function getTemplatePrefix()
    {
        if ($this->templatePrefix !== null) {
            return $this->templatePrefix;
        }

        return $this->getConfig('template_prefix');
    }


    /**
     * @param null $template
     * @return HtmlString
     * @throws \Throwable
     */
    public function renderView($template = null)
    {

        $this->setResults();
        return $this->formHelper->getView()
            ->make($this->getConfig($template, sprintf("admin.%s",$template)))
            ->with('tableView', $this)->render();
    }

    /**
     * Render full form.
     *
     * @param array $options
     * @param bool  $showStart
     * @param bool  $showFields
     * @param bool  $showEnd
     * @return string
     */
    public function renderForm(array $options = [], $showStart = true, $showFields = true, $showEnd = true)
    {
        return $this->render($options, $this->fields, $showStart, $showFields, $showEnd);
    }


    /**
     * Get dot notation key for the form.
     *
     * @return string
     **/
    public function getNameKey()
    {
        return $this->formHelper->transformToDotSyntax($this->name);
    }
    /**
     * Set model to form object.
     *
     * @param mixed $builder
     * @return $this
     * @deprecated deprecated since 1.6.31, will be removed in 1.7 - pass model as option when creating a form
     */
    public function setModel($builder)
    {
        $this->builder = $builder;

       // $this->rebuildForm();

        return $this;
    }
    /**
     * Get model that is bind to form object.
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->builder;
    }

    /**
     * Get form helper.
     *
     * @return DataViewFormHelper
     */
    public function getFormHelper()
    {
        return $this->formHelper;
    }

    /**
     * Get the translation template.
     *
     * @return string
     */
    public function getTranslationTemplate()
    {
        return $this->translationTemplate;
    }


    /**
     * Get the language name.
     *
     * @return string
     */
    public function getLanguageName()
    {
        return $this->languageName;
    }

    public function exits(){

        $this->data = $this->builder->first();

        return $this->data;
    }
    public function edit()
    {
        $this->setRequest(request());

        $this->setFormOptions([
            'url'=>$this->data->getUpdate('api'),
            "method"=>"PUT"
        ]);
        return $this->generate($this->data);

    }


    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function create()
    {
        $this->setRequest(request());
        $this->setFormOptions([
            'url'=>$this->builder->getModel()->getStore('api')
        ]);
        return $this->generate([]);

    }

    protected function generate($data){



        foreach ($this->columns() as $column) {

            $this->add($column->get('field'),$column->get('type'), $column->getOptions($data));

        }

        $this->add('submit', 'submit', $this->getDefaultOption('submit',[]));

        return $this;

    }
    /**
     * Add a FormField to the form's fields.
     *
     * @param AbstractField $field
     * @return $this
     */
    protected function addField(AbstractField $field, $modify = false)
    {
        $this->preventDuplicate($field->getRealName());

        if ($field->getType() == 'file') {
            $this->formOptions['files'] = true;
        }

        $this->fields[$field->getRealName()] = $field;

        return $this;
    }

    /**
     * Create the FormField object.
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     * @return AbstractField
     */
    protected function makeField($name, $type = 'text', array $options = [])
    {
        $this->setupFieldOptions($name, $options);

        $fieldName = $this->getFieldName($name);

        $fieldType = $this->getFieldType($type);

        $field = new $fieldType($fieldName, $type, $this, $options);

        return $field;
    }
    /**
     * Set up options on single field depending on form options.
     *
     * @param string $name
     * @param $options
     */
    protected function setupFieldOptions($name, &$options)
    {
        $options['real_name'] = $name;
    }

    /**
     * If form is named form, modify names to be contained in single key (parent[child_field_name]).
     *
     * @param string $name
     * @return string
     */
    protected function getFieldName($name)
    {
        $formName = $this->getName();
        if ($formName !== null) {
            if (strpos($formName, '[') !== false || strpos($formName, ']') !== false) {
                return $this->formHelper->transformToBracketSyntax(
                    $this->formHelper->transformToDotSyntax(
                        $formName . '[' . $name . ']'
                    )
                );
            }

            return $formName . '[' . $name . ']';
        }

        return $name;
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
     * Prevent adding fields with same name.
     *
     * @param string $name
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function preventDuplicate($name)
    {
        if ($this->has($name)) {
            throw new \InvalidArgumentException('Field ['.$name.'] already exists in the form '.get_class($this));
        }
    }



    /**
     * Render the form.
     *
     * @param array $options
     * @param string $fields
     * @param bool $showStart
     * @param bool $showFields
     * @param bool $showEnd
     * @return string
     */
    protected function render($options, $fields, $showStart, $showFields, $showEnd)
    {
        $formOptions = $this->buildFormOptionsForFormBuilder(
            $this->formHelper->mergeOptions($this->formOptions, $options)
        );

        $this->setupNamedModel();

        return $this->formHelper->getView()
            ->make($this->getTemplate())
            ->with(compact('showStart', 'showFields', 'showEnd'))
            ->with('formOptions', $formOptions)
            ->with('fields', $fields)
            ->with('model', $this->getModel())
            ->with('exclude', $this->exclude)
            ->with('form', $this)
            ->render();
    }

    /**
     * Set namespace to model if form is named so the data is bound properly.
     * Returns true if model is changed, otherwise false.
     *
     * @return bool
     */
    protected function setupNamedModel()
    {
        if (!$this->getModel() || !$this->getName()) {
            return false;
        }

        $dotName = $this->getNameKey();
        $model = $this->formHelper->convertModelToArray($this->getModel());
        $isCollectionFormModel = (bool) preg_match('/^.*\.\d+$/', $dotName);
        $isCollectionPrototype = strpos($dotName, '__NAME__') !== false;

        if (!Arr::get($model, $dotName) && !$isCollectionFormModel && !$isCollectionPrototype) {
            $newModel = [];
            Arr::set($newModel, $dotName, $model);
            $this->model = $newModel;

            return true;
        }

        return false;
    }


    /**
     * @param $formOptions
     * @return array
     */
    protected function buildFormOptionsForFormBuilder($formOptions)
    {
        $reserved = ['method', 'url', 'route', 'action', 'files'];
        $formAttributes = Arr::get($formOptions, 'attr', []);

        // move string value to `attr` to maintain backward compatibility
        foreach ($formOptions as $key => $formOption) {
            if (!in_array($formOption, $reserved) && is_string($formOption)) {
                $formAttributes[$key] = $formOption;
            }
        }

        return array_merge(
            $formAttributes, Arr::only($formOptions, $reserved)
        );
    }


    /**
     * Get template from options if provided, otherwise fallback to config.
     *
     * @return mixed
     */
    protected function getTemplate()
    {
        return $this->getTemplatePrefix() . $this->getFormOption('template', $this->getConfig('form'));
    }
}
