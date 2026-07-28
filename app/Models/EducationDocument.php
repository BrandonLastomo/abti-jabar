<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationDocument extends Model
{
    use \App\Traits\HasDocumentVerifications;

    protected $guarded = [];
}
