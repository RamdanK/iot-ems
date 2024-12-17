<?php

namespace App\Models;

use App\DeviceStatusEnum;
use App\Models\Scopes\DeviceOwnerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Device extends Model
{
    protected $fillable = ['name', 'type', 'description', 'uid', 'status'];

    protected static function booted(): void
    {
        static::addGlobalScope(new DeviceOwnerScope);
    }

    protected function casts(): array
    {
        return [
            'status' => DeviceStatusEnum::class
        ];
    }

    public function owner(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Project::class, 'id', 'id', 'project_id', 'user_id');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(DeviceStatus::class);
    }
}
