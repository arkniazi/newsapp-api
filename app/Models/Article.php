<?php

namespace App\Models;

use App\Scopes\UserPreferenceScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'news_source_id',
        'title',
        'slug',
        'description',
        'source_url',
        'thumbnail_url',
        'published_at',
        'author',
    ];


    protected static function booted()
    {
        static::addGlobalScope(new UserPreferenceScope);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function news_source(): BelongsTo
    {
        return $this->belongsTo(NewsSource::class);
    }
}
