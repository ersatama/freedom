<?php

namespace App\Http\Resources\Exchange;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'valute_id'       => $this->valute_id,
            'num_code'        => $this->num_code,
            'char_code'       => $this->char_code,
            'nominal'         => $this->nominal,
            'name'            => $this->name,
            'value'           => $this->value,
            'value_diff'      => $this->value_diff,
            'value_old'       => $this->value_old,
            'vunit_rate'      => $this->vunit_rate,
            'vunit_rate_diff' => $this->vunit_rate_diff,
            'vunit_rate_old'  => $this->vunit_rate_old,
            'date'            => $this->date,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'deleted_at'      => $this->deleted_at,
        ];
    }
}
