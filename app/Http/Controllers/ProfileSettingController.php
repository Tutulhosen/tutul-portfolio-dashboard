<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileSettingController extends Controller
{
    //show setting page
    public function profile_setting(){
        return view('setting.setting');
    }

    // Update logo
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {

            $userProfile = auth()->user()->profile;

            
            if ($userProfile && $userProfile->logo) {
                $previousLogoPath = 'public/' . $userProfile->logo; 
                Storage::delete($previousLogoPath);
            }

     
            $logoPath = $request->file('logo')->store('logos', 'public');

       
            if ($userProfile) {
                $userProfile->update([
                    'logo' => $logoPath,
                ]);
            } else {
                UserProfile::create([
                    'user_id' => auth()->id(),
                    'logo' => $logoPath,
                ]);
            }

            return response()->json([
                'success' => true,
                'logo_url' => Storage::url($logoPath),  
            ]);
        }

        return response()->json(['error' => 'Logo update failed.'], 400);
    }


    //update profile photo
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');

           
            if ($profile && $profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $profile->update(['profile_picture' => $imagePath]);

            return response()->json(['message' => 'Profile picture updated successfully!', 'profile_picture_url' => asset('storage/' . $imagePath)]);
        }

        return response()->json(['error' => 'Invalid file'], 400);
    }

    //resume upload
    public function updateResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf|max:2048', 
        ]);

        $user = auth()->user();
        $profile = $user->profile;
  
        if ($profile) {
         
            
            $imagePath = $request->file('resume')->store('resume', 'public');

           
            if ($profile && $profile->resume) {
                Storage::disk('public')->delete($profile->resume);
            }

            $profile->update(['resume' => $imagePath]);
            

            return response()->json(['message' => 'Resume updated successfully!', 'resume_url' => asset('storage/' . $imagePath)]);
        }

        return response()->json(['error' => 'Profile not found.'], 404);
    }

    //update profile info
    public function updateProfileInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->profile->update([
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'designation' => $request->designation,
            'short_description' => $request->short_description,
        ]);

        return response()->json(['message' => 'Profile info updated successfully!']);
    }

    //update media link
    public function updateMediaLinks(Request $request)
    {
        $request->validate([
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
        ]);

        $user = auth()->user();
        $user->profile->update([
            'github' => $request->github,
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
        ]);

        return response()->json(['message' => 'Media links updated successfully!']);
    }

    //update password
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string',
            'old_password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
        ]);

        $user = auth()->user();

        // Check if old password matches
        if (!Hash::check(trim($request->old_password), $user->password)) {
            return response()->json(['error' => 'Old password is incorrect.'], 400);
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make(trim($request->password)),
        ]);

        return response()->json(['message' => 'Password updated successfully!']);
    }








}
