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

    public function youtubeId(): ?string
    {
        return static::extractYoutubeId($this->video);
    }

    public function youtubeEmbedUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id ? 'https://www.youtube.com/embed/'.$id : null;
    }

    public static function extractYoutubeId(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $url = trim($url);

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/live\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public static function normalizeYoutubeUrl(?string $url): ?string
    {
        $id = static::extractYoutubeId($url);

        return $id ? 'https://www.youtube.com/watch?v='.$id : null;
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
