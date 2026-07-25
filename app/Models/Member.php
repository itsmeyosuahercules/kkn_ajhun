<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'nim',
        'age',
        'jurusan',
        'fakultas',
        'universitas',
        'jabatan',
        'phone',
        'photo',
        'cv',
        'bio',
        'instagram',
    ];

    protected static function booted(): void
    {
        static::creating(function (Member $member) {
            if (empty($member->slug)) {
                $base = Str::slug($member->user?->name ?? 'member');
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $member->slug = $slug;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function photoUrl(): string
    {
        return $this->photo
            ? asset('storage/'.$this->photo)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->user->name ?? 'M').'&size=256&background=0d9488&color=fff';
    }

    public function cvUrl(): ?string
    {
        return $this->cv ? asset('storage/'.$this->cv) : null;
    }
}
