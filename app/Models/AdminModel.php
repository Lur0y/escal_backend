<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "admins";
    protected $primaryKey = "username";
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';
}
