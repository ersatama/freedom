<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Trashed implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): Builder
    {
        if (request()->has('trashed')) {
            $trashed = request()->input('trashed');
            if ($trashed === 'with') {
                $builder->where(function ($query) {
                    $query->whereNull('deleted_at')->orWhereNotNull('deleted_at');
                });
            } elseif ($trashed === 'only') {
                $builder->whereNotNull('deleted_at');
            } else {
                $builder->whereNull('deleted_at');
            }
        } else {
            $builder->whereNull('deleted_at');
        }
        return $builder;
    }
}
