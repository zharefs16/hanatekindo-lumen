<?php

namespace Bryanjack\Umsapi\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatusParameters extends Model
{
    protected $fillable = [
        'par_id', 'par_name', 'par_status', 'par_message', 'par_attribute'
    ];
}
