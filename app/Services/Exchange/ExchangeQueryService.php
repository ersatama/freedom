<?php

namespace App\Services\Exchange;

use App\Models\Exchange;
use App\Services\QueryService;

class ExchangeQueryService extends QueryService
{
    public function count(array $data = [])
    {
        return $this->countData(Exchange::class, $data);
    }

    public function get(array $data = [])
    {
        return $this->getData(Exchange::class, $data);
    }

    public function first(array $data = [])
    {
        return $this->firstData(Exchange::class, $data);
    }
}