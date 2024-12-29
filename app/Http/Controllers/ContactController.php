<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   
    // Show contact list in the dashboard
    public function show()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('contact.show', compact('contacts'));
    }

    // Edit contact
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.edit', compact('contact'));
    }

    // Update contact
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact->update($request->all());

        return response()->json(['success' => true, 'message' => 'Contact updated successfully!']);
    }


    // Delete contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return response()->json([
            'success' => true,
            'redirect_url' => route('contact.show') 
        ]);
    }
}

