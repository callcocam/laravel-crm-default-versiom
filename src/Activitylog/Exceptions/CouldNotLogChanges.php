<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace SIGA\Activitylog\Exceptions;

use Exception;

class CouldNotLogChanges extends Exception
{
    public static function invalidAttribute($attribute)
    {
        return new static("Cannot log attribute `{$attribute}`. Can only log attributes of a model or a directly related model.");
    }
}
