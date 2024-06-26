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

class Currency extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new Pagination());
        static::addGlobalScope(new Trashed());
    }

    protected $table = 'currencies';

    protected $fillable
        = [
            'currency_id',
            'name',
            'eng_name',
            'nominal',
            'parent_code',
        ];
}
