<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use App\Models\AboutMe;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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




}

