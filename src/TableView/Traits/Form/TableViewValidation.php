<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\TableView\Traits\Form;

use Illuminate\Http\Request;

trait TableViewValidation
{
    /**
     * Wether errors for each field should be shown when calling form($form) or form_rest($form).
     *
     * @var bool
     */
    protected $showFieldErrors = true;

    /**
     * Enable html5 validation.
     *
     * @var bool
     */
    protected $clientValidationEnabled = true;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Define the error bag name for the form.
     *
     * @var string
     */
    protected $errorBag = 'default';

    /**
     * Returns wether form errors should be shown under every field.
     *
     * @return bool
     */
    public function haveErrorsEnabled()
    {
        return $this->showFieldErrors;
    }

    /**
     * Enable or disable showing errors under fields
     *
     * @param bool $enabled
     * @return $this
     */
    public function setErrorsEnabled($enabled)
    {
        $this->showFieldErrors = (bool) $enabled;

        return $this;
    }

    /**
     * Is client validation enabled?
     *
     * @return bool
     */
    public function clientValidationEnabled()
    {
        return $this->clientValidationEnabled;
    }

    /**
     * Enable/disable client validation.
     *
     * @param bool $enable
     * @return $this
     */
    public function setClientValidationEnabled($enable)
    {
        $this->clientValidationEnabled = (bool) $enable;

        return $this;
    }

    /**
     * Get current request.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set request on form.
     *
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }


    public function getErrorBag()
    {
        return $this->errorBag;
    }
}
