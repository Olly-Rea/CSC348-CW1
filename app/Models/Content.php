<?php

namespace App\Models;

use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    // Disable timestamps
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'position',
        'type',
        'content',
        'sub_content',
    ];

    /**
     * Parent Post Model relationship
     */
    public function user() {
        return $this->belongsTo('App\Models\Post');
    }

    // Function to call on the content loadImage method
    public function loadImage() {
        return PostController::loadImage($this->content);
    }

}
