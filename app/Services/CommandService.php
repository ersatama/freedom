<?php

namespace App\Services;

abstract class CommandService
{
    public function createData($model, $data)
    {
        return $model::create($data);
    }

    public function updateData($model, $data)
    {
        foreach ($data as $key => $value) {
            $model->{$key} = $value;
        }
        $model->save();
        return $model;
    }
}