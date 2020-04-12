<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace SIGA\Activitylog;

use Illuminate\Contracts\Config\Repository;

class ActivityLogStatus
{
    protected $enabled = true;

    public function __construct(Repository $config)
    {
        $this->enabled = $config['activitylog.enabled'];
    }

    public function enable(): bool
    {
        return $this->enabled = true;
    }

    public function disable(): bool
    {
        return $this->enabled = false;
    }

    public function disabled(): bool
    {
        return $this->enabled === false;
    }
}
