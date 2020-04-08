<?php


if (!function_exists('form')) {

    function form(\SIGA\TableView\TableViewForm $form, array $options = [])
    {
        return $form->renderForm($options);
    }

}


if (!function_exists('form_start')) {

    /**
     * @param \SIGA\TableView\TableViewForm $form
     * @param array $options
     * @return string
     */
    function form_start(\SIGA\TableView\TableViewForm $form, array $options = [])
    {
        return $form->renderForm($options, true, false, false);
    }

}

if (!function_exists('form_end')) {

    /**
     * @param \SIGA\TableView\TableViewForm $form
     * @param bool $showFields
     * @return mixed
     */
    function form_end(\SIGA\TableView\TableViewForm $form, $showFields = true)
    {
        return $form->renderRest(true, $showFields);
    }

}



if (! function_exists('tableView')) {
    /**
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder $data
     * @return \SIGA\TableView\TableView
     */
    function tableView($data)
    {
        return new SIGA\TableView\TableView($data);
    }
}

if (! function_exists('tableViewColumns')) {
    /**
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder $data
     * @return \SIGA\TableView\TableView
     */
    function tableViewColumns($data)
    {
        return new SIGA\TableView\DataViewsColumns($data);
    }
}


if (! function_exists('tableViewForm')) {
    /**
     * @return \SIGA\TableView\TableView
     */
    function tableViewForm()
    {
        return new SIGA\TableView\TableViewForm();
    }
}

if (!function_exists('form_rest')) {

    /**
     * @param \SIGA\TableView\TableViewForm $form
     * @return mixed
     */
    function form_rest(\SIGA\TableView\TableViewForm $form)
    {
        return $form->renderRest(false);
    }

}

if (!function_exists('form_until')) {

    /**
     * @param \SIGA\TableView\TableViewForm $form
     * @param $field_name
     * @return mixed
     */
    function form_until(\SIGA\TableView\TableViewForm $form, $field_name)
    {
        return $form->renderUntil($field_name, false);
    }

}

if (!function_exists('form_row')) {

    /**
     * @param \SIGA\TableView\Fields\AbstractField $formField
     * @param array $options
     * @return string
     */
    function form_row(\SIGA\TableView\Fields\AbstractField $formField, array $options = [])
    {

        return $formField->render($options);
    }

}

if (!function_exists('form_rows')) {
    /**
     * @param \SIGA\TableView\TableViewForm $form
     * @param array $fields
     * @param array $options
     * @return string
     */
    function form_rows(\SIGA\TableView\TableViewForm $form, array $fields, array $options = [])
    {
        return implode(array_map(function($field) use ($form, $options) {
            return $form->has($field) ? $form->getField($field)->render($options) : '';
        }, $fields));
    }
}

if (!function_exists('form_label')) {

    function form_label(FormField $formField, array $options = [])
    {
        return $formField->render($options, true, false, false);
    }

}

if (!function_exists('form_widget')) {

    function form_widget(FormField $formField, array $options = [])
    {
        return $formField->render($options, false, true, false);
    }

}

if (!function_exists('form_errors')) {

    function form_errors(FormField $formField, array $options = [])
    {
        return $formField->render($options, false, false, true);
    }

}

if (!function_exists('form_fields')) {

    function form_fields(Form $form, array $options = [])
    {
        return $form->renderForm($options, false, true, false);
    }

}
