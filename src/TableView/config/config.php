<?php

return [
    'defaults'      => [
        'wrapper_class'       => 'form-group row',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'col-form-label col-md-3 col-sm-3 label-align',
        'field_class'         => 'form-control',
        'field_error_class'   => '',
        'help_block_class'    => 'help-block',
        'error_class'         => 'text-danger',
        'required_class'      => 'required'

        // Override a class from a field.
        //'text'                => [
        //    'wrapper_class'   => 'form-field-text',
        //    'label_class'     => 'form-field-text-label',
        //    'field_class'     => 'form-field-text-field',
        //]
        //'radio'               => [
        //    'choice_options'  => [
        //        'wrapper'     => ['class' => 'form-radio'],
        //        'label'       => ['class' => 'form-radio-label'],
        //        'field'       => ['class' => 'form-radio-field'],
        //],
    ],
    // Templates
    'partials_buttons_create'         => 'laravel-form-builder::partials.buttons.create',
    'partials_buttons_index'          => 'laravel-form-builder::partials.buttons.index',
    'partials_buttons_actions'        => 'laravel-form-builder::partials.buttons.actions',


    'search'        => 'laravel-form-builder::filters.search',
    'status'        => 'laravel-form-builder::filters.status',
    'items-page'    => 'laravel-form-builder::filters.items-page',
    'date'          => 'laravel-form-builder::filters.date',
    'index'         => 'laravel-form-builder::index',
    'show'          => 'laravel-form-builder::show',
    'create'        => 'laravel-form-builder::create',
    'edit'          => 'laravel-form-builder::edit',
    'form'          => 'laravel-form-builder::form',
    'open'          => 'laravel-form-builder::open',
    'close'         => 'laravel-form-builder::close',
    'text'          => 'laravel-form-builder::text',
    'textarea'      => 'laravel-form-builder::textarea',
    'button'        => 'laravel-form-builder::button',
    'buttongroup'   => 'laravel-form-builder::buttongroup',
    'radio'         => 'laravel-form-builder::radio',
    'checkbox'      => 'laravel-form-builder::checkbox',
    'select'        => 'laravel-form-builder::select',
    'choice'        => 'laravel-form-builder::choice',
    'repeated'      => 'laravel-form-builder::repeated',
    'child_form'    => 'laravel-form-builder::child_form',
    'collection'    => 'laravel-form-builder::collection',
    'static'        => 'laravel-form-builder::static',

    // Remove the laravel-form-builder:: prefix above when using template_prefix
    'template_prefix'   => '',

    'default_namespace' => '',

    'custom_fields' => [
//        'datetime' => App\Forms\Fields\Datetime::class
    ]
];
