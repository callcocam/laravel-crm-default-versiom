<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;


use SIGA\TableView\TableViewColumn;

trait TableViewTypes
{


    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function column($name, $title = null)
    {

        return $this->closure($name,null, $title);
    }


    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function view($name, $title = null)
    {
        return $this->closure($name,function ($model) use($name){
            return view(sprintf('partials.%s',$name), [
                'data'=>$model->{$name}
            ]);
        }, $title);
    }

    /**
     * @param $value
     * @param $callable
     * @param null $title
     * @return TableViewColumn
     */
    public function closure( $name, $callable, $title = null):TableViewColumn
    {

        if (!is_string($title)) {
            $title = str_replace('_', ' ', ucfirst($name));
        }

        $column = new TableViewColumn($title, $callable, $name, $this->table);

        $this->columns[] = $column;

        return $column;
    }


    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function textarea($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('textarea');

        return $column;
    }
    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function text($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('text');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function status($name, $title = null)
    {
        $column = $this->view($name,null, $title);

        $column->type('choice')->choices([
            'all'=>"Tudo",
            'published'=>"Ativo",
            'draft'=>"Inativo",
        ])->expanded(true);

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function choice($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('choice');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function select($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('select');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function checkbox($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('checkbox');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function radio($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('radio');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function password($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('password');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function hidden($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('hidden');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function file($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('file');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function date($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('date');

        return $column;
    }

    /**
     * @param $name
     * @param null $title
     * @return TableViewColumn
     */
    public function email($name, $title = null)
    {
        $column = $this->closure($name,null, $title);

        $column->type('email');

        return $column;
    }
}
