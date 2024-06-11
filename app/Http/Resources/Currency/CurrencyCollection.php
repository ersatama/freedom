<?php

namespace App\Http\Resources\Currency;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use JsonSerializable;

class CurrencyCollection extends ResourceCollection
{
    public function toArray(Request $request): array|Collection|JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new CurrencyResource($request);
        });
    }
}
