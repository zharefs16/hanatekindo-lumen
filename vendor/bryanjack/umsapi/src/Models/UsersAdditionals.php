<?php

namespace Bryanjack\Umsapi\Models;

use Illuminate\Database\Eloquent\Model;

class UsersAdditionals extends Model
{
    protected $fillable = [
        'app_id', 'user_id', 'nama_field', 'value', 'created_user', 'updated_user'
    ];
}
