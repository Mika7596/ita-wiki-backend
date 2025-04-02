<?php

declare (strict_types= 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Support\Facades\DB;

class Like extends Model
{
    use HasFactory;
    
    protected $table = 'likes';
    protected $fillable = ['github_id', 'resource_id', 'like_dislike'];

    /* AN ALTERNATIVE TO TRIGGERS AND CONTROLLER LOGIC
    protected static function booted()
    {
        // Increment like_count when a like is created
        static::creating(function ($like) {
            DB::table('resources')
                ->where('id', $like->resource_id)
                ->increment('like_count', $like->like_dislike);
        });

        // Decrement like_count when a like is deleted
        static::deleting(function ($like) {
            DB::table('resources')
                ->where('id', $like->resource_id)
                ->decrement('like_count', $like->like_dislike);
        });

        // Adjust like_count when a like is updated
        static::updating(function ($like) {
            $difference = $like->like_dislike - $like->getOriginal('like_dislike');
            DB::table('resources')
                ->where('id', $like->resource_id)
                ->increment('like_count', $difference);
        });
    }
    */

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'github_id', 'github_id');
    }
}
