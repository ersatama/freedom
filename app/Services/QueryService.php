<?php

namespace App\Services;

use App\Models\Scopes\Pagination;

abstract class QueryService
{
    public function countData($model, array $data)
    {
        return $model::withoutGlobalScope(Pagination::class)->where($data)->count();
    }

    public function getData($model, array $data)
    {
        return $model::where($data)->get();
    }

    public function firstData($model, array$data)
    {
        return $model::where($data)->first();
    }
}