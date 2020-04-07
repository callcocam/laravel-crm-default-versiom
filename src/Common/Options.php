<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;

use Illuminate\Support\Arr;

trait Options
{

    protected $defaultOptions = [
        'title'=>"Tables"
    ];

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getDefaultOption($key, $default=null){

        return Arr::get($this->defaultOptions,$key,$default);

    }

    /**
     * @param array $defaultOptions
     * @return $this
     */
    protected function setDefaultOptions(array $defaultOptions){

        if($defaultOptions){

            foreach ($defaultOptions as $key => $defaultOption) {

                $this->setDefaultOption($key, $defaultOption);
            }
        }

        return $this;
    }

    /**
     * @param $key
     * @param $defaultOption
     * @return $this
     */
    protected function setDefaultOption($key, $defaultOption){


        $this->defaultOptions[$key] = $defaultOption;

        return $this;

    }

    public function setSubmit($options =[]){

        $this->defaultOptions["submit"] = array_merge([
            'label' => "Salvar Dados",
            'name' => "submit",
            'cancel' => $this->getIndex('api'),
            'attr'=>[
                'class'=>'btn btn-primary m-1'
            ]
        ], $options);
    }
}
