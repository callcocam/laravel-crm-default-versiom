<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields;


class ButtonType extends AbstractField
{

    /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'button';
    }

    /**
     * @inheritdoc
     */
    protected function getDefaults()
    {
        return [
             'wrapper' => false,
            'attr' => ['type' => $this->type]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAllAttributes()
    {
        // Don't collect input for buttons.
        return [];
    }
}
