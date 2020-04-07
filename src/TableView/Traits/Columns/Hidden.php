<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace SIGA\TableView\Traits\Columns;


trait Hidden
{


    public function hidden_list($hidden_list=false)
    {
        $this->render['hidden_list'] = $hidden_list;

        return $this;
    }


    public function hidden_detail($hidden_detail=false)
    {
        $this->render['hidden_detail'] = $hidden_detail;

        return $this;
    }

    public function hidden_create($hidden_create=false)
    {
        $this->render['hidden_create'] = $hidden_create;

        return $this;
    }

    public function hidden_edit($hidden_edit=false)
    {
        $this->render['hidden_edit'] = $hidden_edit;

        return $this;
    }


}
