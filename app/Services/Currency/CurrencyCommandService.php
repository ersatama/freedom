<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Services\CommandService;

class CurrencyCommandService extends CommandService
{
    public function create(array $data)
    {
        return $this->createData(Currency::class, $data);
    }
}