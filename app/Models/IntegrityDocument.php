<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrityDocument extends Model
{
    use \App\Traits\HasDocumentVerifications;

    protected $guarded = [];
}
