<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'title',
        'slug',
        'activity_date',
        'location',
        'description',
        'cover_photo',
        'video',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Report $report) {
            if (empty($report->slug)) {
                $base = Str::slug($report->title).'-'.now()->format('ymd');
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $report->slug = $slug;
            }
        });
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ReportPhoto::class)->orderBy('order');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ReportLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ReportComment::class)->latest();
    }

    public function coverUrl(): string
    {
        if ($this->cover_photo) {
            return asset('storage/'.$this->cover_photo);
        }

        $first = $this->photos->first();

        return $first ? asset('storage/'.$first->photo) : 'https://placehold.co/800x500?text=KKN+Taman+Sari';
    }

    public function hasVideoFile(): bool
    {
        // Path storage (reports/videos/...) — bukan ID YouTube lama
        return filled($this->video) && str_contains($this->video, '/');
    }

    public function videoUrl(): ?string
    {
        return $this->hasVideoFile() ? asset('storage/'.$this->video) : null;
    }

    public function isLikedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
