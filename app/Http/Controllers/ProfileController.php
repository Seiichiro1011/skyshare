<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    private $user;
    const LOCAL_STORAGE_FOLDER = 'public/avatars/';


    public function __construct(User $user)
    {
        $this->user=$user;
    }
    public function  show($id){
        $user=$this->user->findOrFail($id);
        return view('users.profile.show')->with('user',$user);
    }
    public function edit(){
        $user=$this->user->findOrFail(Auth::user()->id);

        return view('users.profile.edit')->with('user',$user);
    }
    public function update (Request $request){
        #Validate the request
        $request->validate([
            'name'=>'required|min:1|max:50',
            'email'=>'required|min:1|max:50|unique:users,email,' . Auth::user()->id,
            'avatar'=>'mimes:jpg,png,jpeg,gif|max:1048',
            'introduction'=>'max:100'
        ]);

        $user=$this->user->findOrFail(Auth::user()->id);

        $user->name=$request->name;
        $user->email=$request->email;
        $user->introduction=$request->introduction;
        if($request->avatar){
        $this->deleteAvatar($user->avatar);
        $user->avatar=$this->saveAvatar($request);
        }

        $user->save();

        return redirect()->route('profile.show',Auth::user()->id);
    }
    private function saveAvatar($request){
        #rename the image to the Current time to avoid overwriting
        $avatar_name=time() . "." . $request->avatar->extension();

        #Save the image inside storage/app/public/image/
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER,$avatar_name);

        return $avatar_name;
    }
    private function deleteAvatar($avatar_name){
        $avatar_path=self::LOCAL_STORAGE_FOLDER . $avatar_name;
        if(Storage::disk('local')->exists($avatar_path)){
            Storage::disk('local')->delete($avatar_path);
        }
    }
    public function followers($id){
        $user=$this->user->findOrFail($id);
        return view('users.profile.followers')->with('user',$user);
       }
    public function following($id){
        $user=$this->user->findOrFail($id);
        return view('users.profile.following')->with('user',$user);
       }
    public function updatePass(Request $request){
        if(!(Hash::check($request->old_password,Auth::user()->password))){
            return redirect()->back()->with('old_password_error',"That's not your current password. Try again.");
        }
        if(Hash::check($request->new_password,Auth::user()->password)){
            return redirect()->back()->with('new_password_error',"New password cannot be the same as your current password. Try again.");
        }
        $request->validate([
            'new_password'=>['required',Password::min(8)->letters()->numbers()],
            'password_confirmation'=>'required|min:8|same:new_password',
        ]);
        // if(!(Hash::check($request->new_password,$request->c_pass))){
        //     return redirect()->back()->with('c_pass_error',"New Password and Confirmation Password don't match");
        // }
       $user=Auth::user();
       $user->password=Hash::make($request->new_password);
       $user->save();

        return redirect()->back()->with('success',"Your password is successfully changed");


    }
}
