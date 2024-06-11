<?php

namespace App\Models;

use App\Models\Scopes\{
    Pagination,
    Trashed
};
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class Exchange extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new Pagination());
        static::addGlobalScope(new Trashed());
    }

    protected $table = 'exchanges';
    protected $appends
        = [
            'value_diff',
            'value_old',
            'vunit_rate_diff',
            'vunit_rate_old',
        ];

    protected $fillable
        = [
            'valute_id',
            'num_code',
            'char_code',
            'nominal',
            'name',
            'value',
            'vunit_rate',
            'date',
        ];
}
