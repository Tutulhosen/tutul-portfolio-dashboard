<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
     //show list
     public function show()
     {
         $achievements = Achievement::latest()->paginate(10); 
         return view('achievement.show', compact('achievements'));
     }
 
     // create form
     public function create()
     {
         return view('achievement.create'); 
     }
 
     //store achievement data
     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
         ]);
 
         try {
             $achievement = new achievement();
             $achievement->title = $request->title;
             $achievement->description = $request->description;
             $achievement->achieved_at = $request->achieved_at;
 
             if ($request->hasFile('image')) {
                 $imagePath = $request->file('image')->store('achievements', 'public');
                 $achievement->attached_file = $imagePath;
             }
 
             $achievement->save();
 
             return response()->json(['success' => true, 'message' => 'achievement saved successfully!']);
         } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => 'Failed to save achievement.']);
         }
     }
 
     //update status
     public function updateStatus($id)
     {
         $task = Achievement::findOrFail($id);
 
      
         $task->status = $task->status == 1 ? 0 : 1;
         $task->save();
 
         return response()->json(['status' => $task->status]);
     }
 
     //edit page
     public function edit($id)
     {
         $achievement = Achievement::findOrFail($id); 
         return view('achievement.edit', compact('achievement'));
     }
 
     //update
     public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        // dd($request->description);
        try {
            $achievement = Achievement::findOrFail($id);
            $achievement->title = $request->title;
            $achievement->description = $request->description;
            $achievement->achieved_at = $request->achieved_at;

            if ($request->hasFile('image')) {
                if ($achievement->attached_file && file_exists(storage_path('app/public/' . $achievement->attached_file))) {
                    unlink(storage_path('app/public/' . $achievement->attached_file));
                }

                $imagePath = $request->file('image')->store('achievements', 'public');
                $achievement->attached_file = $imagePath;
            }

            $achievement->save();

            return response()->json(['success' => true, 'message' => 'Achievement updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update achievement.']);
        }
    }

 
 
 
 
     //delete
     public function destroy($id)
     {
  
         $task = Achievement::findOrFail($id);
 
       
         if ($task->image && Storage::exists('public/' . $task->image)) {
             Storage::delete('public/' . $task->image);
         }
 
 
         $task->delete();
 
         return response()->json([
             'success' => true,
             'redirect_url' => route('achievement.show') 
         ]);
     }
 
 
}
