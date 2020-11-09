<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'postID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userID',
        'title',
        'content',
        'tags',
        'likes',
        'dislikes'
    ];

    /**
     * Parent Model relationship
     */
    public function user() {
        return $this->belongsTo("App\Models\User", "userID");
    }

    /**
     * Child Model relationship
     */
    public function comments() {
        return $this->hasMany("App\Models\Comment", "postID");
    }

}
