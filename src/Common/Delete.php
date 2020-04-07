<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;


use SIGA\TraitTable;

trait Delete
{
    public function deleteBy($model)
    {
        /**
         * @var TraitTable $model
         */
        if ($model) {
            if ($model->delete()) {
                return $this->setMessages(true,'destroy');
            }
        }
        return $this->setMessages(false,'destroy');
    }


    public function deleteAll($data)
    {
        /**
         * @var TraitTable $model
         */
        $model = $this->query()->whereIn('id', $data);

        if ($model) {
            $this->results = [
                'model' => $model->delete()
            ];
            return $this->setMessages(true,'destroy');
        }

        return $this->setMessages(false,'destroy');
    }

}
