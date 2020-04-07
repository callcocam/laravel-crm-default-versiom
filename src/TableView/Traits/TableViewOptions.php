<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits;

use Illuminate\Support\Arr;

trait TableViewOptions
{

    protected $defaultOptions = [];
    protected $appendsQueries = false;
    protected $paginator = null;

    private $searchFields = [];

    public function setDefaultOptions($setDefaultOptions)
    {
        $this->defaultOptions = $setDefaultOptions;

        return $this;
    }

   public function getDefaultOption($key, $default=null){

       return Arr::get($this->defaultOptions,$key, $default);
   }
    /**
     * @param string $key
     * @param string $default
     * @param array $customConfig
     * @return mixed
     */
    public function getConfig($key = null, $default = null, $customConfig = [])
    {
        $config = array_replace_recursive($this->config, $customConfig);

        if ($key) {
            return Arr::get($config, $key, $default);
        }

        return $config;
    }

    public function getEndpoint(){

        return $this->builder->getModel()->getEndpoint();
    }
}
