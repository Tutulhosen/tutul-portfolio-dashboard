<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutMe;

class AboutMeController extends Controller
{
    // Show the "About Me" form
    public function create()
    {
        return view('about.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $about = new AboutMe;
        $about->content = $request->input('content');
        $about->save();

        return response()->json([
            'success' => true,
            'message' => 'About Me section saved successfully.',
            'redirect' => route('about.show') 
        ]);
    }





    public function show()
    {
        $aboutMe = AboutMe::latest()->paginate(10); 
        return view('about.show', compact('aboutMe'));
    }

    public function updateStatus($id)
    {
        $task = AboutMe::findOrFail($id);

     
        $task->status = $task->status == 1 ? 0 : 1;
        $task->save();

        return response()->json(['status' => $task->status]);
    }

    public function edit($id)
    {
      
        $aboutMe = AboutMe::findOrFail($id);
        
   
        return view('about.edit', compact('aboutMe'));
    }


    public function update(Request $request, $id)
    {
       
        $request->validate([
            'content' => 'required|string',
        ]);


        $aboutMe = AboutMe::findOrFail($id);
        $aboutMe->content = $request->content;
        $aboutMe->save();

 
        return response()->json([
            'success' => true,
            'message' => 'About Me updated successfully.',
            'redirect' => route('about.show'), 
        ]);
    }

    public function destroy($id)
    {
        $task = AboutMe::findOrFail($id);
        $task->delete();

        return response()->json([
            'success' => true,
            'redirect_url' => route('about.show') 
        ]);
    }





}
