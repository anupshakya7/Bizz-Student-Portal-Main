<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    //Mobile OTP
    public function otp(){
        return view('profile.mobile_otp');
    }

    //Mobile Verify
    public function generate(Request $request){
        $request->validate([
            'country_code'=>'required',
            'mobile'=>'required|exists:users,mobile'
        ]);

        $userOTP = $this->generateOTP($request->mobile);

        if (!$userOTP) {
            return redirect()->back()->with('error', 'User not found or an error occurred while generating OTP.');
        }

        $userOTP->sendSMS($request->country_code.$request->mobile);

        return redirect()->route('profile.otp.checkmobile')->with('success','OTP has been sent on your Mobile Number!');
    }

    public function generateOTP($mobile){
        $user = User::where('mobile',$mobile)->first();

        if(!$user){
            return redirect()->back()->with('error', 'User not found.');
        }

        $now = now();
        if(!empty($user->otp_expired_at) && $now->isBefore($user->otp_expired_at)){
            return $user;
        }

        $user->update([
            'mobile_otp_code'=> rand(123456,999999),
            'otp_expired_at' => $now->addMinutes(10) 
        ]);

        return $user;
    }

    public function checkMobileOTP(){
        return view('profile.otp_verification');
    }

    public function verification(Request $request){
        $request->validate([
            'mobile'=>'required|exists:users,mobile',
            'otp'=>'required'
        ]); 

        $userOTP = User::where('mobile',$request->mobile)->where('mobile_otp_code',$request->otp)->first();
        $now = now();
        if(!$userOTP){
            return redirect()->back()->with('error','Your OTP is not Correct');
        }elseif($userOTP && $now->isAfter($userOTP->otp_expired_at)){
            return redirect()->back()->with('error','Your OTP has been Expired');
        }

        $userOTP->update([
            'mobile_verified_at'=>$now 
        ]);
        return redirect()->route('profile.editProfile')->with('success','Your OTP is verify Successfully!!!');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'firstname' => 'required|min:2|max:100',
            'lastname' => 'required|min:2|max:100',
            'mobile' => ['required','min:10','max:15', Rule::unique('users','mobile')->ignore(auth()->user()->id)],
            'address' => 'required|min:2|max:100',
        ]);

        $user = auth()->user();
        // if (!$user) {
        //     return redirect()->route('login')->with('error', 'User not Authenticated');
        // }

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
            $user->update([
                'profile_image' => $imageName,
            ]);   
        }

        $oldNumberUser = $user->where('mobile',$request->mobile)->first();

        if(!$oldNumberUser){
            $user->update([
                'mobile_otp_code'=>null,
                'otp_expired_at'=>null,
                'mobile_verified_at'=>null
            ]);
        }
           
        $updateStatus = $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'mobile'=>$request->mobile,
            'address'=>$request->address
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
