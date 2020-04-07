<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use SIGA\Company;
use SIGA\Http\Requests\CompanyRequest;

class CompanyController extends AbstractController
{

    protected $model = Company::class;

    public function update(CompanyRequest $request, $id)
    {
        return parent::save($request, $id);
    }

    public function store(CompanyRequest $request)
    {
       return parent::save($request);
    }
}
