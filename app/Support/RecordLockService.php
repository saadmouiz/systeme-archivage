<?php

namespace App\Support;

use App\Models\EditLock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RecordLockService
{
    public const TTL_MINUTES = 5;

    public function acquire(Model $model, $user): array
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('edit_locks')) {
            return ['acquired' => true, 'lock' => null, 'message' => null];
        }

        $this->purgeExpired();

        $type = $model->getMorphClass();
        $id = $model->getKey();
        $existing = EditLock::query()
            ->where('lockable_type', $type)
            ->where('lockable_id', $id)
            ->first();

        if ($existing && !$existing->isExpired() && (int) $existing->user_id !== (int) $user->id) {
            return [
                'acquired' => false,
                'lock' => $existing,
                'message' => sprintf(
                    'Ce dossier est actuellement en cours de modification par %s.',
                    $existing->user_name ?: ('Utilisateur #' . $existing->user_id)
                ),
            ];
        }

        $lock = EditLock::updateOrCreate(
            ['lockable_type' => $type, 'lockable_id' => $id],
            [
                'user_id' => $user->id,
                'user_name' => $user->name ?? null,
                'expires_at' => now()->addMinutes(self::TTL_MINUTES),
            ]
        );

        return ['acquired' => true, 'lock' => $lock, 'message' => null];
    }

    public function heartbeat(Model $model, $user): bool
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('edit_locks')) {
            return true;
        }

        $lock = EditLock::query()
            ->where('lockable_type', $model->getMorphClass())
            ->where('lockable_id', $model->getKey())
            ->where('user_id', $user->id)
            ->first();

        if (!$lock) {
            return false;
        }

        $lock->update(['expires_at' => now()->addMinutes(self::TTL_MINUTES)]);
        return true;
    }

    public function release(Model $model, $user = null): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('edit_locks')) {
            return;
        }

        $query = EditLock::query()
            ->where('lockable_type', $model->getMorphClass())
            ->where('lockable_id', $model->getKey());

        if ($user) {
            $query->where('user_id', $user->id);
        }

        $query->delete();
    }

    public function currentLock(Model $model): ?EditLock
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('edit_locks')) {
            return null;
        }

        $this->purgeExpired();

        return EditLock::query()
            ->where('lockable_type', $model->getMorphClass())
            ->where('lockable_id', $model->getKey())
            ->where('expires_at', '>', now())
            ->first();
    }

    public function purgeExpired(): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('edit_locks')) {
            return;
        }

        EditLock::query()->where('expires_at', '<=', Carbon::now())->delete();
    }
}
