<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    public static function log(Model $model, string $action, array $changes = [], $user = null): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
            return;
        }

        $user = $user ?: auth()->user();

        AuditLog::create([
            'auditable_type' => $model->getMorphClass(),
            'auditable_id' => $model->getKey(),
            'user_id' => $user->id ?? null,
            'user_name' => $user->name ?? null,
            'action' => $action,
            'changes' => $changes ?: null,
            'ip' => Request::ip(),
        ]);
    }

    public static function diff(Model $model, array $before, array $after): array
    {
        $changes = [];
        foreach ($after as $key => $value) {
            $old = $before[$key] ?? null;
            $new = $value;
            if ($old instanceof \DateTimeInterface) {
                $old = $old->format('Y-m-d H:i:s');
            }
            if ($new instanceof \DateTimeInterface) {
                $new = $new->format('Y-m-d H:i:s');
            }
            if ((string) $old !== (string) $new) {
                $changes[$key] = ['old' => $old, 'new' => $new];
            }
        }
        return $changes;
    }
}
