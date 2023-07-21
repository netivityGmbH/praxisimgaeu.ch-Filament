<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "key",
        "firstname",
        "lastname",
        "total_events",
        "active",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "created_at" => "datetime:d.m.Y",
    ];

    /**
     * Get events for this subscription
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
