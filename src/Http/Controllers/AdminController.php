<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;


use Illuminate\Filesystem\Filesystem;

class AdminController extends AbstractController
{


    public function language(Filesystem $filesystem)
    {
       return $filesystem->get(resource_path(sprintf("lang/%s.json", app()->getLocale())),true);
    }
}
