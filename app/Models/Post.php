<?php

namespace App\Models;

use App\Models\Post as ModelsPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    # to get the owner of the post
    public function user(){

        return $this->belongsTo(User::class)->withTrashed();
    }
    # To get all rhe categories of a post
    public function emotionPost(){
        return $this->hasMany(EmotionPost::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    # To get the likes of a post
    public function likes(){
        return $this->hasMany(Like::class);
    }
    #returns true if the Auth user already liked the post
    public function isLiked(){
        return $this->likes()->where('user_id',Auth::user()->id)->exists();
    }
}

// emotion_post
// singular form of each table ,alphabetical order
