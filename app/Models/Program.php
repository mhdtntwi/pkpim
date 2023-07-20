<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'slug',
        'location',
        'date',
        'description',
        'status',
        'attendance',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_logs')
            ->withPivot('attendance', 'submitted', 'joined')
            ->withTimestamps();
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class, 'program_id');
    }
}
