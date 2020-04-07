<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView;

use SIGA\TableView\Traits\Columns\Choices;
use SIGA\TableView\Traits\Columns\Entity;
use SIGA\TableView\Traits\Columns\Hidden;
use SIGA\TableView\Traits\Columns\Options;

class TableViewColumn
{

    use Entity, Hidden, Options, Choices;

    protected $closure;
    protected $dataValuesSelected=[];
    /**
     * Name of the property for value setting.
     *
     * @var string
     */
    protected $valueProperty = 'value';

    protected $render = [
        'field'=>'',
        'name'=>'',
        'table'=>'',
        'title'=>'',
        'alias'=>'',
        'refer'=>'',
        'type'=>'text',
        'label'=>'',
        'value'=>null,
        'default_value'=>null,
        'callable'=>null,
        'sorter'=>false,
        'width'=>150,
        'options'=>[],
        'attributes'=>[],
        'format'=>'text',
        'icone'=>'icon-chevron-right',
        'hidden_list'=>false,
        'hidden_show'=>true,
        'hidden_detail'=>true,
        'hidden_create'=>true,
        'hidden_edit'=>true,
    ];


    public function __construct($title, $callable, $name, $table)
    {

           $this->field($name);

           $this->table($table);

           $this->callable($callable);

            $this->title($title);

            $this->attribute('id', $name);

            $this->attribute('placeholder', $title);

            $this->name($name);

            $this->alias(sprintf("%s.%s", $table,$name));


    }

    /**
     * Nome da tabela as vezes pode ser a tabela da chave estrangeira
     * @param $table
     * @return $this
     */
    public function table($table)
    {

        $this->render['table'] = $table;

        return $this;
    }

    /**
     * Nome real do campo não e alterado em momento algum
     * @param $field
     * @return $this
     */
    public function field($field)
    {
        $this->render['field'] = $field;

        return $this;
    }

    /**
     * Pode ser alterado
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->render['name'] = $name;

        return $this;
    }

    /**
     * Titulo rotulo ou label da tabela e do campo de formulario
     * @param $title
     * @return $this
     */
    public function title($title)
    {

        $this->render['title'] = $title;

        return $this;
    }

    /**
     * Usado para se referenciar a outro campo ex: category se refere a category_id da tabela categories
     * @param $refer
     * @return $this
     */
    public function refer($refer)
    {

        $this->render['refer'] = $refer;

        return $this;
    }

    /**
     * apelido por exemplo users.name, user.description
     * @param $alias
     * @return $this
     */
    public function alias($alias)
    {
        $this->render['alias'] = $alias;

        return $this;
    }


    /**
     * para gerar uma função anonima
     * @param $callable
     * @return $this
     */
    public function callable($callable)
    {

        $this->render['callable'] = $callable;

        $this->closure = $callable;

        return $this;
    }


    /**
     * @return mixed
     */
    public function propertyName()
    {
        return $this->render['field'];
    }


    public function rowValue($model)
    {
        $closure = $this->propertyName();

        if($this->closure)
            $closure = $this->closure;

        if(is_callable($closure)){
            $rowValue =  $closure($model);
        }
        else
        {
            $rowValue =   $model->{$closure};
        }

        return $rowValue;
    }

    /**
     * pegar o valor sem nenhuma alteração
     * @param $model
     * @return string
     */
    protected function rowRealValue($model)
    {
        if(!$model)
            return '';

        $closure = $this->propertyName();



        //if(!is_string($rowValue) && $rowValue){
        //    dd($rowValue,$closure);
       // }
        return self::getCastedValue($model,$closure);
    }


    /**
     * @param mixed $value
     * @return string
     */
    public function getCastedValue($model,$value)
    {

        if(is_array($model))
        {
            $rowValue =   $model[$value];
        }
        else
        {
            $rowValue =   $model->{$value};
        }

        return $rowValue;
    }
    public function getOptions($model){

        $this->dataValuesSelected[$this->valueProperty] = $this->rowRealValue($model);

        return array_filter(array_merge($this->defaultValues($model),
            $this->appendOptionsChoices,
            $this->appendOptionsEntity,
            $this->dataValuesSelected));
    }

    protected function defaultValues($model){


        return [
            'attr' => $this->get('attributes',[]),
            'default_value' => $this->get('default_value'),
            'label' => $this->get('title'),
            'label_show' => $this->get('label_show', true),
            'is_child' =>  $this->get('is_child', false),
            'errors' => $this->get('errors', null),
            'rules' => $this->get('rules', []),
            'error_messages' => $this->get('error_messages', [])
        ];
    }

    public function get($key, $default=null){

        if(isset($this->render[$key]))
            return $this->render[$key];

        return $default;
    }
}
