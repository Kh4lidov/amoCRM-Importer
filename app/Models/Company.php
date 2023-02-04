<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public const FILLABLE_FIELDS = [
        'id',
        'name',
        'responsible_user_id',
        'group_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'closest_task_at',
        'account_id',
    ];

    protected $fillable = self::FILLABLE_FIELDS;

}
