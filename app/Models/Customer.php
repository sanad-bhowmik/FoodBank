<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'phone',
        'address',
    ];

}
