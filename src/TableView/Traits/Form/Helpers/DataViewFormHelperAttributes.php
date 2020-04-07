<?php


namespace SIGA\TableView\Traits\Form\Helpers;


trait DataViewFormHelperAttributes
{


    /**
     * Convert array of attributes to html attributes.
     *
     * @param $options
     * @return string
     */
    public function prepareAttributes($options)
    {
        if (!$options) {
            return null;
        }

        $attributes = [];

        foreach ($options as $name => $option) {
            if ($option !== null) {
                $name = is_numeric($name) ? $option : $name;
                $attributes[] = $name.'="'.$option.'" ';
            }
        }

        return join('', $attributes);
    }
}
