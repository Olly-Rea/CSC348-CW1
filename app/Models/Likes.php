<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    // Disable timestamps
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',  
    ];

    /**
     * User model relationship
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }
    /**
     * Post model relationship
     */
    public function likeable() {
        return $this->morphTo();
    }

}
