<?php

namespace Bryanjack\Umsapi\Models;

use Illuminate\Database\Eloquent\Model;

class Umsapi extends Model
{
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
