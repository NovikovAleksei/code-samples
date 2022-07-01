<?php

class Practitioner
{
    protected string $connection = 'mysql';

    protected array $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected array $fillable = [
        'first_name',
        'last_name',
    ];

    public function listeners(): BelongsToMany
    {
        return $this->belongsToMany(Listener::class);
    }

    /**
     * Get only active practitioner
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}