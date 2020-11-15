<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Define the custom primary key identifier
    protected $primaryKey = 'tag_id';
    // Disable timestamps
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Parent Model relationships
     */
    public function post() {
        return $this->belongsToMany("App\Models\Post", "post_id", "tag_id");
    }

}
