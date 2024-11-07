<?php

namespace Bryanjack\Umsapi\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'id', 'app_id', 'app_ip', 'key_app', 'dynamic_app', 'status'
    ];
}
