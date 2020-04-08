<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Fields;


class TextareaType extends AbstractField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'textarea';
    }
}
