<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;


trait Helper
{

    protected $lastId;

    protected $queryParams = [];

    protected $messages = [];

    protected $results = [
        'result' => false,
        'type' => 'is-danger',
        'errors' => "Falhou, não foi possivel realizar a operação!!",
        'message' => "Falhou, não foi possivel realizar a operação!!",
        'title' => 'Operação:'
    ];
    /**
     * @param $key
     * @param null $default
     * @return |null
     */
    protected function params($key, $default=null){

        if(isset($this->queryParams[$key]))
            return $this->queryParams[$key];

        return $default;
    }

    /**
     * @return array
     */
    protected function paramsAll(){

        return $this->queryParams;
    }


    protected function setMessages($result, $operation="index"){

        $messageAppend = [];

        if($this->messages){

            if(!isset($this->messages))
                $this->messages[] = $this->messages;

            foreach ($this->messages as $message){

                $messageAppend[] = $message;

            }

            $this->results['logs'] =  $messageAppend;
        }
        $this->results['title'] = config("siga.admin.table.{$operation}.messages.title",'Operação:');

        if($result){
            $this->results['result'] = $result;
            $this->results['type'] = config("siga.admin.table.{$operation}.messages.type.success",'success:');
            $this->results['redirect'] = $this->addIndex();
            $this->results['messages'] =  config("siga.admin.table.{$operation}.messages.message.success","Realizada com sucesso, registro foi excluido com sucesso!!");
            return $result;
        }

        $this->results['result'] = $result;
        $this->results['type'] = config("siga.admin.table.{$operation}.messages.type.error",'danger:');
        $this->results['messages'] =  sprintf(config("siga.admin.table.{$operation}.messages.message.error","Falhou, não foi possivel encontrar o registro - %s!!"), $this->getKey());
        return $result;
    }

    /**
     * @return array
     */
    public function getResults()
    {

        return $this->results;
    }

    /**
     * @param $key
     * @return bool
     */
    public function getResult($key)
    {
        if (isset($this->results[$key])) {
            return $this->results[$key];
        }
        return false;
    }

    /**
     * @return string
     */
    public function getResultLastId()
    {
        if(is_string($this->lastId)){
            return $this->lastId;
        }
        if($this->lastId){
            return $this->lastId->toString();
        }
        return $this->lastId;
    }
}
