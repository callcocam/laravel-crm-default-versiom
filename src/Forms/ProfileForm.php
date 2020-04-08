<?php


namespace SIGA\Forms;


use SIGA\TableView\TableViewForm;

class ProfileForm extends TableViewForm
{

    public function buildForm()
    {

        $this
            ->add('name', 'text',[
                'label_show' => false,
            ])
            ->add('email', 'email',[
                'label_show' => false,
            ])
            ->add('description', 'textarea',[
                'label_show' => false,
            ])
            ->add('publish', 'checkbox',[
                'label_show' => false,
            ]);
        parent::buildForm(); // TODO: Change the autogenerated stub
    }
}