<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory; // Trait
    use SoftDeletes;

    protected $perPage = 6;

    protected $fillable = [
        'title', 'content', 'slug', 'category_id', 'user_id',
        'status', 'image',
    ];

    // Attribute Accessors

    // $post->image_url
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/default-image.jpg');
        }

        //return asset('storage/' . $this->image);
        return Storage::disk('public')->url($this->image);
    }

    protected static function booted()
    {
        /*static::addGlobalScope('published', function(Builder $builder) {
            $builder->where('status', '=', 'published');
        });*/
        //static::addGlobalScope(new PublishedScope());

        static::observe(new PostObserver());

        static::saving(function(Post $post) {
            $post->slug = Str::slug($post->title);
        });

        static::forceDeleted(function(Post $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }

    // Local Scope (published)
    public function scopePublished(Builder $builder)
    {
        $builder->where('status', '=', 'published');
    }

    public function scopeDraft(Builder $builder)
    {
        $builder->where('status', '=', 'draft');
    }

    public function scopeStatus(Builder $builder, $status = 'published')
    {
        $builder->where('status', '=', $status);
    }

    // Inverse of One-to-Many (Post belongs to only one category)
    public function category()
    {
        return $this->belongsTo(
            Category::class,    // Related Model 
            'category_id',      // FK for the related in the current model
            'id'                // PK in the related model
        )->withDefault([
            'name' => 'N/A'
        ]);
    }

    // Many-to-Many (Post belong to many Tags)
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related model 
            'post_tag',     // Pivot table
            'post_id',      // FK in pivot table for current model
            'tag_id',       // FK in pivot table for related model
            'id',           // PK for current model
            'id'            // PK for related model
        )->withPivot([
            'post_id', 'tag_id'
        ])
        ->as('details');
    }
}
