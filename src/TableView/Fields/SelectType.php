<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields;


use SIGA\TableView\TableViewForm;

class SelectType extends AbstractField
{

    /**
     * The name of the property that holds the value.
     *
     * @var string
     */
    protected $valueProperty = 'selected';

    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'select';
    }

    /**
     * @inheritdoc
     */
    public function getDefaults()
    {
        return [
            'choices' => [],
            'selected' => null,
            'empty_value' => '=== Select ===',
        ];
    }

}
