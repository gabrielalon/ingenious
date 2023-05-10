<?php

namespace Support\DAO\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

/**
 * @method static Builder byUuid(UuidInterface|string $uuid)
 */
trait HasUuidTrait
{
    public static function bootHasUuidTrait(): void
    {
        static::creating(static function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if (empty($model->$uuidFieldName)) {
                $model->$uuidFieldName = static::generateUuid();
            }
        });
    }

    public static function generateUuid(): string
    {
        return Str::uuid()->toString();
    }

    public static function findByUuid(UuidInterface|string $uuid): ?Model
    {
        return static::query()->byUuid($uuid)->first();
    }

    public function scopeByUuid(Builder $query, UuidInterface|string $uuid): Builder
    {
        return $query->where($this->getUuidFieldName(), (string) $uuid);
    }

    public function getUuidFieldName(): string
    {
        if (! empty($this->uuidFieldName)) {
            return $this->uuidFieldName;
        }

        return $this->getKeyName();
    }
}
