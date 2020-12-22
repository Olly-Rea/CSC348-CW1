<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'post_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'likes',
        'dislikes'
    ];

    /**
     * Parent Model relationship
     */
    public function user() {
        return $this->belongsTo("App\Models\User", "user_id");
    }

    public function tags() {
        return $this->belongsToMany("App\Models\Tag", "post_id", "tag_id");
    }

    /**
     * Child Model relationship
     */
    public function comments() {
        return $this->hasMany("App\Models\Comment", "post_id")->orderBy('created_at', 'DESC');
    }

}
