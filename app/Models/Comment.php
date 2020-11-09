<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'commentID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userID',
        'postID',
        'content',
        'likes',
        'dislikes'
    ];

    /**
     * Parent Model relationships
     */
    public function user() {
        return $this->belongsTo("App\Models\User", "userID");
    }
     public function post() {
        return $this->belongsTo("App\Models\Post", "postID");
    }

    /**
     * Child Model relationship
     */
    public function replies() {
        return $this->hasMany("App\Models\Reply", "commentID");
    }

}
