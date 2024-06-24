<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function dashboard(){
        return view('profile.dashboard');
    }

    public function editProfile(){
        return view('profile.profile');
    }

    public function updateProfile(Request $request){

    }
}
