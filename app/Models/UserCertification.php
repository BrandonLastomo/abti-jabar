<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCertification extends Model
{
    use \App\Traits\HasDocumentVerifications;

    protected $guarded = [];
}
