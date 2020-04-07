<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields;


class CheckableType extends AbstractField
{

    /**
     * @inheritdoc
     */
    protected $valueProperty = 'checked';

    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public function getDefaults()
    {
        return [
            'attr' => ['class' => null, 'id' => $this->getName()],
            'value' => 1,
            'checked' => null
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function isValidValue($value)
    {
        return $value !== null;
    }
}
