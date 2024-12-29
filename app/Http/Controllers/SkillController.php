<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Show the list of skills
    public function show()
    {
        $skills = Skill::latest()->paginate(10);
        
        return view('skill.show', compact('skills'));
    }

    // Show the form to create a new skill
    public function create()
    {
        return view('skill.create');
    }

     // Store a new skill 
     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'icon' => 'nullable|string|max:255',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
     
         $skill = new Skill();
         $skill->title = $request->input('title');
         $skill->icon = $request->input('icon');
     
         if ($request->hasFile('image')) {
             $imagePath = $request->file('image')->store('skills', 'public');
             $skill->image = $imagePath;
         } else {
       
             $skill->image = 'default_skill_image.jpg'; 
         }
     
         $skill->save();
     
         return response()->json(['success' => true, 'message' => 'Skill saved successfully.']);
     }
     

    // Show the form to edit a skill
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('skill.edit', compact('skill'));
    }

    // Update the skill 
    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        
        $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $skill->title = $request->input('title');
        $skill->icon = $request->input('icon');


        if ($request->hasFile('image')) {
        
            if ($skill->image && file_exists(public_path('storage/' . $skill->image))) {
                unlink(public_path('storage/' . $skill->image));
            }

      
            $imagePath = $request->file('image')->store('skills', 'public');
            $skill->image = $imagePath;
        }

        $skill->save();

        return redirect()->route('skill.show')->with('success', 'Skill updated successfully!');
    }


    // Delete the skill from the database
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);

        if ($skill->image && file_exists(public_path('storage/' . $skill->image))) {
     
            unlink(public_path('storage/' . $skill->image));
        }

      
        $skill->delete();

        return redirect()->route('skill.show')->with('success', 'Skill deleted successfully!');
    }

}
