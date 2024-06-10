<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Services\QueryService;

class CurrencyQueryService extends QueryService
{
    public function get(array $data)
    {
        return $this->getData(Currency::class, $data);
    }

    public function first(array $data)
    {
        return $this->firstData(Currency::class, $data);
    }
}