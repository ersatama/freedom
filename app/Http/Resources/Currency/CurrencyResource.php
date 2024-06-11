<?php

namespace App\Http\Resources\Currency;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return collect([
            'id'          => $this->id,
            'currency_id' => $this->currency_id,
            'name'        => $this->name,
            'eng_name'    => $this->eng_name,
            'nominal'     => $this->nominal,
            'parent_code' => $this->parent_code,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at'  => $this->deleted_at,
        ])->filter()->toArray();
    }
}
