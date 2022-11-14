<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;
    private $like;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post,User $user, Like $like)
    {
        $this->post=$post;
        $this->user=$user;
        $this->like=$like;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_posts=$this->post->latest()->paginate(10);
        $liked_users=$this->like->all();
        $suggested_users=$this->getSuggestedUsers();
        return view('users.home')->with('all_posts',$all_posts)
                                ->with('suggested_users',$suggested_users)
                                ->with('liked_users',$liked_users);
    }
    public function suggestions()
    {
        $all_posts=$this->post->latest()->paginate(10);
        $suggested_users=$this->getSuggestedUsers();
        return view('users.suggestions')->with('all_posts',$all_posts)
                                ->with('suggested_users',$suggested_users);
    }
    private function getSuggestedUsers(){
        $all_users=$this->user->all()->except(Auth::user()->id);
        $suggested_users=[];
        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users[]=$user;
            }
        }
        return $suggested_users;
    }
    public function search(Request $request){
        $users=$this->user->where('name','like','%'.$request->search.'%')->get();
        return view('users.search')->with('users',$users)->with('search',$request->search);
    }


}
