<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'replyID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userID',
        'commentID',
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
     public function comment() {
        return $this->belongsTo("App\Models\Comment", "commentID");
    }

}
