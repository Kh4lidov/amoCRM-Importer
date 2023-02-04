<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
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
        'account_id',
        'pipeline_id',
        'status_id',
        'closed_at',
        'closest_task_at',
        'price',
        'loss_reason_id',
        'company_id',
    ];

    protected $fillable = self::FILLABLE_FIELDS;
}
