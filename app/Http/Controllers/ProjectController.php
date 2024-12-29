<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    //show list
    public function show()
    {
        $projects = Project::latest()->paginate(10); 
        return view('project.show', compact('projects'));
    }

    // create form
    public function create()
    {
        return view('project.create'); 
    }

    //store project data
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'link' => 'nullable|url',
        ]);

        try {
            $project = new Project();
            $project->title = $request->title;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->link = $request->link;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects', 'public');
                $project->image = $imagePath;
            }

            $project->save();

            return response()->json(['success' => true, 'message' => 'Project saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save project.']);
        }
    }

    //update status
    public function updateStatus($id)
    {
        $task = Project::findOrFail($id);

     
        $task->status = $task->status == 1 ? 0 : 1;
        $task->save();

        return response()->json(['status' => $task->status]);
    }

    //edit page
    public function edit($id)
    {
        $project = Project::findOrFail($id); 
        return view('about.edit', compact('project'));
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'link' => 'nullable|url',
        ]);

        try {
            $project = Project::findOrFail($id); 
            $project->title = $request->title;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->link = $request->link;

            if ($request->hasFile('image')) {
                
                if ($project->image && file_exists(storage_path('app/public/' . $project->image))) {
                    unlink(storage_path('app/public/' . $project->image));
                }
               
                $imagePath = $request->file('image')->store('projects', 'public');
                $project->image = $imagePath;
            }

            $project->save(); 

            return redirect()->route('project.show')->with('success', 'Project updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update project.');
        }
    }




    //delete
    public function destroy($id)
    {
 
        $task = Project::findOrFail($id);

      
        if ($task->image && Storage::exists('public/' . $task->image)) {
            Storage::delete('public/' . $task->image);
        }


        $task->delete();

        return response()->json([
            'success' => true,
            'redirect_url' => route('project.show') 
        ]);
    }





}
