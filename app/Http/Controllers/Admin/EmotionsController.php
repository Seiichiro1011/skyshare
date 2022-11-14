<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\emotion;
use App\Models\Post;

class EmotionsController extends Controller
{
    private $emotion;
    private $post;

    public function __construct(Emotion $emotion,Post $post)
    {
        $this->emotion=$emotion;
        $this->post=$post;
    }
    public function index(){
        $all_emotions=$this->emotion->orderBy('updated_at','DESC')->get();
        $count=$this->count();
        return view('admin.emotions.index')->with('all_emotions',$all_emotions)->with('count',$count);
    }
    public function store (Request $request){
        #Validate the request
        $request->validate([
            'name'=>'required|max:50'
        ]);
        $this->emotion->name=ucwords(strtolower(($request->name)));
        $this->emotion->save();

        return redirect()->back();
    }
    public function update (Request $request,$id){
        #Validate the request
        $request->validate([
            'name'=>'required|max:50'
        ]);
        $emotion=$this->emotion->findOrFail($id);
        $emotion->name=ucwords(strtolower(($request->name)));
        $emotion->save();
        return redirect()->back();
    }
    public function destroy($id){
    $emotion=$this->emotion->findOrFail($id);
    $emotion->destroy($id);
    return redirect()->back();
}
    private function count(){
        $all_posts=$this->post->get();
        $count=0;
        foreach($all_posts as $post){
            if($post->emotionPost->count()==0){
                $count++;
            }
        }
        return $count;
    }
}
