<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;


trait Eloquent
{
    /*
     *  Builder
     */
    protected $source;

    protected $forgingsIgnore=['companies','users'];
    protected $forgingsIgnoreColumns=['is_admin','email_verified_at','remember_token','deleted_at','company_id','password'];


    public function getSources()
    {
        if (!$this->source) {
            $this->source = $this->query();
        }
        return $this->source;
    }


    public function innerJoin(){

        $connection = $this->source->getConnection()->getDoctrineConnection();

        $schema = $connection->getSchemaManager();

        $foreignKeys = $schema->listTableForeignKeys($this->getTable());

        $fields =[];

        if($foreignKeys){
            foreach ( $foreignKeys as $foreignKey ) {
                if(!in_array($foreignKey->getForeignTableName(), $this->forgingsIgnore)){
                    if($foreignKey->getForeignTableName() != $this->getTable()){
                        $columns = $schema->listTableColumns( $foreignKey->getForeignTableName() );
                        $fields[] = [
                            'name' => $foreignKey->getName(),
                            'field' => $foreignKey->getLocalColumns()[0],
                            'references' => $foreignKey->getForeignColumns()[0],
                            'on' => $foreignKey->getForeignTableName(),
                            'columns'=>$this->getFields($columns)
                        ];
                    }
                }

            }
        }
        return $fields;
    }

    protected function getFields($columns)
    {
        $fields = array();
        foreach ($columns as $column) {
            $name = $column->getName();
            if(!in_array($name, $this->forgingsIgnoreColumns)) {
                $fields[$name] = $column->getName();
            }
        }
        return $fields;
    }
    protected function order()
    {
        $column = $this->params('column','id');

        $order = $this->params('order','desc');

        $this->source->orderBy(sprintf("%s.%s",$this->getTable(),$column), $order);
    }

    protected function initQuery()
    {

        if ($this->params('status')) {

            if ($this->params('status','all') !="all") {
                $this->source->where(sprintf("%s.%s",$this->getTable(),config('siga.eloquent.filter.default_status','status')) , $this->params('status'));
            }
        }

        if ($this->params('start',false) && $this->params('end',false)) {
            $this->source->whereBetween(sprintf("%s.%s",$this->getTable(),config('siga.eloquent.filter.default_date','created_at')), [
                date_carbom_format($this->params('start'))->format('Y-m-d 00:00:00'),
                date_carbom_format($this->params('end'))->format('Y-m-d 23:59:59')
            ]);
        }

        $date =sprintf("%s.%s",$this->getTable(),config('siga.eloquent.filter.default_date','created_at'));
        if (request()->has('year'))
            $this->source->whereYear($date, '=', $this->params('year'));
        if (request()->has('month'))
            $this->source->whereMonth($date, '=', $this->params('month'));
        if (request()->has('day'))
            $this->source->whereDay($date, '=', $this->params('day'));
        if (request()->has('date'))
            $this->source->whereDate($date, '=', $this->params('date'));
        if (request()->has('number'))
            $this->source->where(sprintf('%s.number',$this->getTable()), '=', request()->get('number'));

    }

}
