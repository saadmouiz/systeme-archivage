<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'user_id',
        'user_name',
        'action',
        'changes',
        'ip',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
