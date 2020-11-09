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
        'author',
        'comment',
        'content',
        'likes',
        'dislikes'
    ];

    /**
     * Parent model relationship
     */
    public function user() {
        return $this->belongsTo("App\Models\User", "author");
    }
     public function comment() {
        return $this->belongsTo('App\Models\Comment');
    }

}
