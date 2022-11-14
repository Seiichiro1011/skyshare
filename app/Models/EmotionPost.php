<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmotionPost extends Model
{
    use HasFactory;

    protected $table="emotion_post";
    protected $fillable=['post_id','emotion_id'];
    //allow mass assignment
    public $timestamps=false;

    #To get the category name
    public function emotion(){
        return $this->belongsTo(Emotion::class);
    }
}
