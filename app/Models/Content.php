<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
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
        'post_id',
        'position',
        'content_type',
        'content',
    ];

    /**
     * Parent Post Model relationship
     */
    public function user() {
        return $this->belongsTo('App\Models\Post');
    }

}
