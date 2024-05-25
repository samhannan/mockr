<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

/**
 * @method static replicating(\Closure $param)
 * @method static creating(\Closure $param)
 */
trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'uuid')) {
                if (!$model->uuid) {
                    $model->uuid = (string)Uuid::uuid4();
                }
            }
        });

        static::replicating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeWhereUuid(Builder $query, $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeWhereUuids(Builder $query, iterable $uuids): Builder
    {
        return $query->whereIn('uuid', $uuids);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
