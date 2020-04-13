<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\View\Factory as View;

class AbstractDataViewFormHelper
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param View    $view
     * @param Translator $translator
     * @param array   $config
     */
    public function __construct(View $view, Translator $translator, array $config = [])
    {
        $this->view = $view;
        $this->translator = $translator;
        $this->config = $config;
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

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

}
