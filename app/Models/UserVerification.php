<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    /** @use HasFactory<\Database\Factories\UserVerificationFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'id_uploaded'];
}
