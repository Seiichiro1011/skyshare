<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Like;
use App\Models\Emotion;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    private $post;
    private $like;
    private $emotion;
    const LOCAL_STORAGE_FOLDER = 'public/images/';

    public function __construct(Post $post, Emotion $emotion, Like $like)
    {
        $this->post = $post;
        $this->like = $like;
        $this->emotion = $emotion;
    }
    public function create()
    {
        $all_emotions = $this->emotion->all();

        return view('users.posts.create')->with('all_emotions', $all_emotions);
    }
    public function store(Request $request)
    {
        #Validate the request
        $request->validate([
            'emotion' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        # Save the post
        $this->post->user_id = Auth::user()->id;
        $this->post->image = $this->saveImage($request);
        $this->post->description = $request->description;
        $this->post->save();

        #Save the categories to the emotion_post table
        foreach ($request->emotion as $emotion_id) {
            $emotion_post[] = ['emotion_id' => $emotion_id];
        }
        $this->post->emotionPost()->createMany($emotion_post);

        #Go back to homepage

        return redirect()->route('index');
    }
    private function saveImage($request)
    {
        #rename the image to the Current time to avoid overwriting

        $image_name = time() . "." . $request->image->extension();

        #Save the image inside storage/app/public/image/
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }
    public function show($id)
    {
        $post = $this->post->findOrFail($id);
        $liked_users = $this->like->all();
        return view('users.posts.show')->with('post', $post)
            ->with('liked_users', $liked_users);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        if (Auth::user()->id !== $post->user->id) {
            return redirect()->route('index');
        }

        $all_categories = $this->emotion->all();

        #Get all the emotion IDs of this post. Save in an array
        $selected_categories = [];
        foreach ($post->emotionPost as $emotion_post) {
            $selected_categories[] = $emotion_post->emotion_id;
        }

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }
    public function update(Request $request, $id)
    {
        #Validate the request
        $request->validate([
            'emotion' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        # Update the post
        $post = $this->post->findOrFail($id);
        // $post->user_id=Auth::user()->id;
        $post->description = $request->description;

        $post->emotionPost()->delete();
        #Save the categories to the emotion_post table
        foreach ($request->emotion as $emotion_id) {
            $emotion_post[] = ['emotion_id' => $emotion_id];
        }
        $post->emotionPost()->createMany($emotion_post);

        if ($request->image) {
            $this->deleteImage($post->image);
            $post->image = $this->saveImage($request);
        }

        $post->save();

        return redirect()->route('post.show', $id);
    }
    private function deleteImage($image_name)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;
        if (Storage::disk('local')->exists($image_path)) {
            Storage::disk('local')->delete($image_path);
        }
    }
    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);
        $post->forceDelete($id);
        return redirect()->route('index');
    }
}
