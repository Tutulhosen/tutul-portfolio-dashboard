<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use App\Models\Skill;
use Illuminate\Http\Request;

class FrontendDataController extends Controller
{
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




}

