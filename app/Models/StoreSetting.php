<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'shop_name',
        'address',
        'phone',
        'tax_id',
    ];
}
