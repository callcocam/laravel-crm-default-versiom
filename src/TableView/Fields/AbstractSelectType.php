<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields;


use Illuminate\Support\Arr;
use SIGA\TableView\TableViewForm;

abstract class AbstractSelectType extends AbstractField
{

    protected $children;
    /**
     * @var string
     */
    protected $choiceType = 'select';
    /**
     * @inheritdoc
     */
    protected $valueProperty = 'selected';

    /**
     * @param       $name
     * @param       $type
     * @param TableViewForm  $parent
     * @param array $options
     * @return void
     */
    public function __construct($name, $type, TableViewForm $parent, array $options = [])
    {

        parent::__construct($name, $type, $parent, $options + ['copy_options_to_children' => true]);
        if ($this->hasDefault) {
            $this->createChildren();
        }
        $this->checkIfFileType();
    }

    /**
     * Check if field has type property and if it's file add enctype/multipart to form.
     *
     * @return void
     */
    protected function checkIfFileType()
    {
        if ($this->getOption('type') === 'file') {
            $this->parent->setFormOption('files', true);
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDefaults()
    {
        return [
            'choices' => null,
            'selected' => null,
            'expanded' => false,
            'multiple' => false,
            'choice_options' => [
                'wrapper' => false,
                'is_child' => true
            ]
        ];
    }

    /**
     * @param  mixed $val
     *
     * @return ChildFormType
     */
    public function setValue($val)
    {
        parent::setValue($val);

        $this->createChildren();

        return $this;
    }

    public function getValue($default = null)
    {
      return parent::getValue($default);
    }

    /**
     * Create children depending on choice type.
     *
     * @return void
     */
    protected function createChildren()
    {

        if (($data_override = $this->getOption('data_override')) && $data_override instanceof \Closure) {
            $this->options['choices'] = $data_override($this->options['choices'], $this);
        }

        $this->children = [];

        $this->determineChoiceField();

        $fieldType = $this->formHelper->getFieldType($this->choiceType);

        switch ($this->choiceType) {
            case 'radio':
            case 'checkbox':
                $this->buildCheckableChildren($fieldType);
                break;
            default:
                $this->buildSelect($fieldType);
                break;
        }
    }
    /**
     * Determine which choice type to use.
     *
     * @return string
     */
    protected function determineChoiceField()
    {
        $expanded = $this->options['expanded'];
        $multiple = $this->options['multiple'];

        if ($multiple) {
            $this->options['attr']['multiple'] = true;
        }

        if ($expanded && !$multiple) {
            return $this->choiceType = 'radio';
        }

        if ($expanded && $multiple) {
            return $this->choiceType = 'checkbox';
        }
    }

    /**
     * Build checkable children fields from choice type.
     *
     * @param string $fieldType
     *
     * @return void
     */
    protected function buildCheckableChildren($fieldType)
    {
        $multiple = $this->getOption('multiple') ? '[]' : '';

        foreach ((array)$this->options['choices'] as $key => $choice) {
            $id = str_replace('.', '_', $this->getNameKey()) . '_' . $key;
            $options = $this->formHelper->mergeOptions(
                $this->getOption('choice_options'),
                [
                    'attr'       => ['id' => $id],
                    'label_attr' => ['for' => $id],
                    'label'      => $choice,
                    'checked'    => in_array($key, (array)$this->options[$this->valueProperty]),
                    'value'      => $key
                ]
            );
            $this->children[] = new $fieldType(
                $this->name . $multiple,
                $this->choiceType,
                $this->parent,
                $options
            );
        }
    }

    /**
     * Build select field from choice.
     *
     * @param string $fieldType
     */
    protected function buildSelect($fieldType)
    {

        $this->children[] = new $fieldType(
            $this->name,
            $this->choiceType,
            $this->parent,
            $this->formHelper->mergeOptions($this->options, ['is_child' => true])
        );
    }

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'choice';
    }

    /**
     * {inheritdoc}
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['children'] = $this->children;
        return parent::render($options, $showLabel, $showField, $showError);
    }


    public function __clone()
    {
        foreach ((array) $this->children as $key => $child) {
            $this->children[$key] = clone $child;
        }
    }
}
