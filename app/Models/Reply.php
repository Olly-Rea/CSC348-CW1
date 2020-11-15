<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'reply_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'comment_id',
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
     public function comment() {
        return $this->belongsTo("App\Models\Comment", "comment_id");
    }

}
