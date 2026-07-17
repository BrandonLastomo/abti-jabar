<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutationSetting extends Model
{
    protected $fillable = [
        'key',
        'value'
    ];
}
