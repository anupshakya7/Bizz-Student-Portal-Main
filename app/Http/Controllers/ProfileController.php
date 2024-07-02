<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('profile.dashboard');
    }

    public function editProfile()
    {
        $user = auth()->user();
        $data['user'] = $user;
        return view('profile.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'firstname' => 'required|min:2|max:100',
            'lastname' => 'required|min:2|max:100'
        ]);

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not Authenticated');
        }

        //Handle Image Upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            //Check if directory Exists if not create
            $directory = public_path('images/users');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            //Move the new image to the directory
            $image->move($directory, $imageName);

            //Delete old image if exists
            if($user->profile_image){
                $oldImagePath = public_path('images/users/'.$user->profile_image);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
            
        } else {
            $imageName = null; //Set image name to null if not provided
        }

        $updateStatus = $user->update([
            'profile_image' => $imageName,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        //Check if update was successfull
        if ($updateStatus) {
            return redirect()->route('profile.editProfile')->with('success', 'Profile Successfully Updated');
        } else {
            return redirect()->route('profile.editProfile')->with('error', 'Failed to Update Profile');
        }
    }

    public function changePassword()
    {
        return view('profile.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6|max:100',
            'new_password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:new_password',
        ]);

        $currentUser = auth()->user();
        if (Hash::check($request->old_password, $currentUser->password)) {
            $currentUser->update([
                'password' => bcrypt($request->new_password)
            ]);
            return redirect()->back()->with('success', 'Password Successfully Updated.');
        } else {
            return redirect()->back()->with('error', 'Old Password does not matched.');
        }
    }
}
