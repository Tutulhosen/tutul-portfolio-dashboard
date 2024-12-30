<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Skill;
use App\Models\AboutMe;
use App\Models\Contact;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class FrontendDataController extends Controller
{

    //login
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists and passwords match
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Issue token
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Return response with token
        return response()->json(['token' => $token]);
    }


    // get about me data
    public function about()
    {
        $about_me = AboutMe::where('status', 1)->first();

        if ($about_me) {
            return response()->json([
                'success' => true,
                'data' => $about_me,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'About Me data not found.',
        ], 404);
    }

    //get skill data
    public function skill()
    {
        $skills = Skill::latest()->get();

        if ($skills) {
            $skills->map(function($skill) {
              
                if ($skill->image) {
                    $skill->image = url('storage/' . $skill->image);
                }
                return $skill;
            });

            return response()->json([
                'success' => true,
                'data' => $skills,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Skill data not found.',
        ], 404);
    }

    //get project data
    public function project(){
        $projects = Project::where('status', 1)->latest()->get();

        if ($projects->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No projects found.',
            ], 404);
        }

        $projects->map(function ($project) {
            if ($project->image) {
                $project->image = url('storage/' . $project->image);
            }
            return $project;
        });

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }


    //store the contact message data
    public function contact(Request $request)
    {
      
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return response()->json(['message' => 'Your message has been sent successfully!'], 200);
    }

    //get hero contant
    public function hero()
    {
        // Assuming the user is authenticated
        $user = auth()->user();

        // Fetch the user with their profile using Eloquent's with() method
        $userWithProfile = User::with('profile')->find($user->id);

        if (!$userWithProfile) {
            $userWithProfile=$user;
        }

        // Return the complete user data including the profile
        return response()->json($userWithProfile);
    }




}

