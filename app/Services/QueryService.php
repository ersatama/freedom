<?php

namespace App\Services;

abstract class QueryService
{
    public function getData($model, array $data)
    {
        return $model::where($data)->get();
    }

    public function firstData($model, array$data)
    {
        return $model::where($data)->first();
    }
}