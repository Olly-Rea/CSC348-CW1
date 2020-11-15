<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'comment_id';

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
        'dislikes'
    ];

    /**
     * Parent Model relationships
     */
    public function user() {
        return $this->belongsTo("App\Models\User", "user_id");
    }
     public function post() {
        return $this->belongsTo("App\Models\Post", "post_id");
    }

    /**
     * Child Model relationship
     */
    public function replies() {
        return $this->hasMany("App\Models\Reply", "comment_id");
    }

}
