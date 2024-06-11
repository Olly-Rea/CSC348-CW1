<?php

namespace App\Models;

use App\Http\Controllers\ProfileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
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
        'about_me',
        'profile_image',
    ];

    /**
     * One-to-One relation.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

    // Function to call on the profile loadImage method
    public function profileImage()
    {
        return ProfileController::loadImage($this->profile_image);
    }
}
