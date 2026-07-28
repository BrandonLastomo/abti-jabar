<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityDocument extends Model
{
    use \App\Traits\HasDocumentVerifications;
    
    protected $guarded = [];
}
