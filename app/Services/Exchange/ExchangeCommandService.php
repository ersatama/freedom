<?php

namespace App\Services\Exchange;

use App\Models\Exchange;
use App\Services\CommandService;

class ExchangeCommandService extends CommandService
{
    public function create(array $data)
    {
        return $this->createData(Exchange::class, $data);
    }
}