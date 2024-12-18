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
            'content' => 'required|string',
        ]);

        AboutMe::create([
            'content' => $request->content,
        ]);
        // Set the success message in the session
        return redirect()->back()->with('success', 'About Me section updated successfully!');
       
    }



    public function show()
    {
        $aboutMe = AboutMe::latest()->first(); 
        return view('about.show', compact('aboutMe'));
    }

}
