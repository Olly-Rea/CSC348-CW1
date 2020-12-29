<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'published',
        'title',
    ];

    /**
     * Parent User Model relationship
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Tag model relationship
     */
    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'post_tags');
    }
    /**
     * 'Likes' model relationship
     */
    public function likes() {
        return $this->morphMany('App\Models\Likes', 'likeable');
    }

    /**
     * Child relationship for post content (text and imagery)
     */
    public function content() {
        return $this->hasMany('App\Models\Content')->orderBy('position');
    }

    /**
     * Child Model relationship
     */
    public function comments() {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

}
