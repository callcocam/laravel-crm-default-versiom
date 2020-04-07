<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SIGA\TableView\DataViewFormHelper;
use SIGA\TableView\Fields\Traits\TraitRules;
use SIGA\TableView\Fields\Traits\TraitValue;
use SIGA\TableView\Rules;
use SIGA\TableView\TableViewForm;

abstract class AbstractField
{

    use TraitValue, TraitRules;
    /**
     * Name of the field.
     *
     * @var string
     */
    protected $name;

    /**
     * Type of the field.
     *
     * @var string
     */
    protected $type;

    /**
     * All options for the field.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Is field rendered.
     *
     * @var bool
     */
    protected $rendered = false;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var DataViewFormHelper
     */
    protected $formHelper;

    /**
     * @var TableViewForm
     */
    protected $parent;

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    abstract protected function getTemplate();


    /**
     * @param string $name
     * @param string $type
     * @param TableViewForm $parent
     * @param array $options
     */
    public function __construct($name, $type, TableViewForm $parent, array $options = [])
    {


        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
        $this->formHelper = $this->parent->getFormHelper();
        $this->setTemplate();
        $this->setDefaultOptions($options);
        $this->setupValue();
    }


    /**
     * Disable field.
     *
     * @return $this
     */
    public function disable()
    {
        $this->setOption('attr.disabled', 'disabled');

        return $this;
    }

    /**
     * Enable field.
     *
     * @return $this
     */
    public function enable()
    {
        Arr::forget($this->options, 'attr.disabled');

        return $this;
    }

    /**
     * Get validation rules for a field if any with label for attributes.
     *
     * @return array|null
     */
    public function getValidationRules()
    {
        $rules = $this->getOption('rules', []);
        $name = $this->getNameKey();
        $messages = $this->getOption('error_messages', []);
        $formName = $this->parent->getNameKey();

        if ($messages && $formName) {
            $newMessages = [];
            foreach ($messages as $messageKey => $message) {
                $messageKey = sprintf('%s.%s', $formName, $messageKey);
                $newMessages[$messageKey] = $message;
            }
            $messages = $newMessages;
        }

        if (!$rules) {
            return (new Rules([]))->setFieldName($this->getNameKey());
        }

        return (new Rules(
            [$name => $rules],
            [$name => $this->getOption('label')],
            $messages
        ))->setFieldName($this->getNameKey());
    }
    /**
     * @return TableViewForm
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Get real name of the field without form namespace.
     *
     * @return string
     */
    public function getRealName()
    {
        return $this->getOption('real_name', $this->name);
    }
    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * Get the type of the field.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Get name of the field.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Get single option from options array. Can be used with dot notation ('attr.class').
     *
     * @param string $option
     * @param mixed|null $default
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return Arr::get($this->options, $option, $default);
    }
    /**
     * @return string
     */
    protected function getViewTemplate()
    {
        return $this->parent->getTemplatePrefix() . $this->getOption('template', $this->template);
    }
    /**
     * Render the field.
     *
     * @param array $options
     * @param bool  $showLabel
     * @param bool  $showField
     * @param bool  $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $this->prepareOptions($options);
        $value = $this->getValue();
        $defaultValue = $this->getDefaultValue();

        if ($showField) {
            $this->rendered = true;
        }

        // Override default value with value
        if (!$this->isValidValue($value) && $this->isValidValue($defaultValue)) {
            $this->setOption($this->valueProperty, $defaultValue);
        }

        if (!$this->needsLabel()) {
            $showLabel = false;
        }

        if ($showError) {
            $showError = $this->parent->haveErrorsEnabled();
        }

        $data = $this->getRenderData();

        return $this->formHelper->getView()->make(
            $this->getViewTemplate(),
            array_merge($data ,[
                'name' => $this->name,
                'nameKey' => $this->getNameKey(),
                'type' => $this->type,
                'options' => $this->options,
                'showLabel' => $showLabel,
                'showField' => $showField,
                'showError' => $showError,
                'errorBag'  => $this->parent->getErrorBag(),
                'translationTemplate' => $this->parent->getTranslationTemplate(),
            ])
        )->render();
    }

    /**
     * Get dot notation key for fields.
     *
     * @return string
     **/
    public function getNameKey()
    {
        return $this->transformKey($this->name);
    }

    /**
     * Check if fields needs label.
     *
     * @return bool
     */
    protected function needsLabel()
    {
        // If field is <select> and child of choice, we don't need label for it
        $isChildSelect = $this->type == 'select' && $this->getOption('is_child') === true;

        if ($this->type == 'hidden' || $isChildSelect) {
            return false;
        }

        return true;
    }

    /**
     * Transform array like syntax to dot syntax.
     *
     * @param string $key
     * @return mixed
     */
    protected function transformKey($key)
    {
        return $this->formHelper->transformToDotSyntax($key);
    }


    /**
     * Prepare options for rendering.
     *
     * @param array $options
     * @return array The parsed options
     */
    protected function prepareOptions(array $options = [])
    {
        $helper = $this->formHelper;

        $this->options = $this->prepareRules($options);
        $this->options = $helper->mergeOptions($this->options, $options);

        $rulesParser = $helper->createRulesParser($this);
        $rules = $this->getOption('rules');
        $parsedRules = $rules ? $rulesParser->parse($rules) : [];


        foreach (['attr', 'label_attr', 'wrapper'] as $appendable) {
            // Append values to the 'class' attribute
            if ($this->getOption("{$appendable}.class_append")) {
                // Combine the current class attribute with the appends
                $append = $this->getOption("{$appendable}.class_append");
                $classAttribute = $this->getOption("{$appendable}.class", '') . ' ' . $append;
                $this->setOption("{$appendable}.class", $classAttribute);

                // Then remove the class_append option to prevent it from showing up as an attribute in the HTML
                $this->setOption("{$appendable}.class_append", null);
            }
        }

        if ($this->getOption('attr.multiple') && !$this->getOption('tmp.multipleBracesSet')) {
            $this->name = $this->name . '[]';
            $this->setOption('tmp.multipleBracesSet', true);
        }

        if ($this->parent->haveErrorsEnabled()) {
            $this->addErrorClass();
        }

        if ($this->getOption('required') === true || isset($parsedRules['required'])) {
            $lblClass = $this->getOption('label_attr.class', '');
            $requiredClass = $this->getConfig('defaults.required_class', 'required');

            if (!Str::contains($lblClass, $requiredClass)) {
                $lblClass .= ' ' . $requiredClass;
                $this->setOption('label_attr.class', $lblClass);
            }

            if ($this->parent->clientValidationEnabled()) {
                $this->setOption('attr.required', 'required');
            }
        }

        if ($this->parent->clientValidationEnabled() && $parsedRules) {
            $attrs = $this->getOption('attr') + $parsedRules;
            $this->setOption('attr', $attrs);
        }

        $this->setOption('wrapperAttrs', $helper->prepareAttributes($this->getOption('wrapper')));
        $this->setOption('errorAttrs', $helper->prepareAttributes($this->getOption('errors')));

        if ($this->getOption('help_block.text')) {
            $this->setOption(
                'help_block.helpBlockAttrs',
                $helper->prepareAttributes($this->getOption('help_block.attr'))
            );
        }

        return $this->options;
    }
    /**
     * Add error class to wrapper if validation errors exist.
     *
     * @return void
     */
    protected function addErrorClass()
    {
        $errors = [];
        if ($this->parent->getRequest()->hasSession()) {
            $errors = $this->parent->getRequest()->session()->get('errors');
        }
        $errorBag = $this->parent->getErrorBag();

        if ($errors && $errors->hasBag($errorBag) && $errors->getBag($errorBag)->has($this->getNameKey())) {
            $fieldErrorClass = $this->getConfig('defaults.field_error_class');
            $fieldClass = $this->getOption('attr.class');

            if ($fieldErrorClass && !Str::contains($fieldClass, $fieldErrorClass)) {
                $fieldClass .= ' ' . $fieldErrorClass;
                $this->setOption('attr.class', $fieldClass);
            }

            $wrapperErrorClass = $this->getConfig('defaults.wrapper_error_class');
            $wrapperClass = $this->getOption('wrapper.class');

            if ($wrapperErrorClass && $this->getOption('wrapper') && !Str::contains($wrapperClass, $wrapperErrorClass)) {
                $wrapperClass .= ' ' . $wrapperErrorClass;
                $this->setOption('wrapper.class', $wrapperClass);
            }
        }
    }

    /**
     * Merge all defaults with field specific defaults and set template if passed.
     *
     * @param array $options
     */
    protected function setDefaultOptions(array $options = [])
    {
        $this->options = $this->formHelper->mergeOptions($this->allDefaults(), $this->getDefaults());
        $this->options = $this->prepareOptions($options);

        $defaults = $this->setDefaultClasses($options);
        $this->options = $this->formHelper->mergeOptions($this->options, $defaults);

        $this->setupLabel();
    }

    /**
     * Setup the label for the form field.
     *
     * @return void
     */
    protected function setupLabel()
    {
        if ($this->getOption('label') !== null) {
            return;
        }

        if ($template = $this->parent->getTranslationTemplate()) {
            $label = str_replace(
                ['{name}', '{type}'],
                [$this->getRealName(), 'label'],
                $template
            );
        } elseif ($langName = $this->parent->getLanguageName()) {
            $label = sprintf('%s.%s', $langName, $this->getRealName());
        } else {
            $label = $this->getRealName();
        }

        $this->setOption('label', $this->formHelper->formatLabel($label));
    }

    /**
     * Set field options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $this->prepareOptions($options);

        return $this;
    }

    /**
     * Set single option on the field.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setOption($name, $value)
    {
        Arr::set($this->options, $name, $value);

        return $this;
    }
    /**
     * Creates default wrapper classes for the form element.
     *
     * @param array $options
     * @return array
     */
    protected function setDefaultClasses(array $options = [])
    {
        $wrapper_class = $this->getConfig('defaults.' . $this->type . '.wrapper_class', '');
        $label_class = $this->getConfig('defaults.' . $this->type . '.label_class', '');
        $field_class = $this->getConfig('defaults.' . $this->type . '.field_class', '');

        $defaults = [];
        if ($wrapper_class && !Arr::get($options, 'wrapper.class')) {
            $defaults['wrapper']['class'] = $wrapper_class;
        }
        if ($label_class && !Arr::get($options, 'label_attr.class')) {
            $defaults['label_attr']['class'] = $label_class;
        }
        if ($field_class && !Arr::get($options, 'attr.class')) {
            $defaults['attr']['class'] = $field_class;
        }
        return $defaults;
    }

    /**
     * Default options for field.
     *
     * @return array
     */
    protected function getDefaults()
    {
        return [];
    }

    /**
     * Defaults used across all fields.
     *
     * @return array
     */
    private function allDefaults()
    {

        return [
            'wrapper' => ['class' => $this->getConfig('defaults.wrapper_class')],
            'attr' => ['class' => $this->getConfig('defaults.field_class')],
            'help_block' => ['text' => null, 'tag' => 'p', 'attr' => [
                'class' => $this->getConfig('defaults.help_block_class')
            ]],
            'value' => null,
            'default_value' => null,
            'label' => null,
            'label_show' => true,
            'is_child' => false,
            'label_attr' => ['class' => $this->getConfig('defaults.label_class')],
            'errors' => ['class' => $this->getConfig('defaults.error_class')],
            'rules' => [],
            'error_messages' => []
        ];
    }
    /**
     * Set the template property on the object.
     *
     * @return void
     */
    private function setTemplate()
    {
        $this->template = $this->getConfig($this->getTemplate(), $this->getTemplate());
    }


    /**
     * Get config from the form.
     *
     * @return mixed
     */
    private function getConfig($key = null, $default = null)
    {
        return $this->parent->getConfig($key, $default);
    }
}
