<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'likes',
    ];

    /**
     * Parent Model relationships
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }
     public function post() {
        return $this->belongsTo("App\Models\Post");
    }

    /**
     * Polymorphic Child Model relationships
     */
    public function commentable() {
        return $this->morphTo();
    }
    public function replies() {
        return $this->morphMany("App\Models\Comment", "commentable");
    }

    /**
     * 'Likes' model relationship
     */
    public function likes() {
        return $this->morphMany('App\Models\Likes', 'likeable');
    }


}
