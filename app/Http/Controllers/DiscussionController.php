<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::all();
        return view('welcome', compact('discussions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('discussions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'picture' => 'nullable|image|max:2048',
        ]);

        $discussion = new Discussion();
        $discussion->title = $request->title;
        $discussion->description = $request->description;
        $discussion->user_id = Auth::id();
        $discussion->category_id = $request->category_id;
        $discussion->is_approved = false;

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(public_path('pictures'), $imageName);

            $discussion->picture = 'pictures/' . $imageName;
        }

        $discussion->save();

        return redirect()->route('home')->with('success', 'Discussion created successfully');
    }

    public function show(string $id)
    {
        $discussion = Discussion::with('user', 'category', 'comments')->findOrFail($id);
        $comments = $discussion->comments()->with('user')->get();
        return view('show', compact('discussion', 'comments'));
    }

    public function edit(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        if (Auth::id() !== $discussion->user_id && !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'You are not authorized to edit this discussion.');
        }

        $categories = Category::all();
        return view('discussions.edit', compact('discussion', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'picture' => 'nullable|image|max:2048',
        ]);

        $discussion = Discussion::findOrFail($id);
        if (Auth::id() !== $discussion->user_id && !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'You are not authorized to update this discussion.');
        }

        $discussion->title = $request->title;
        $discussion->description = $request->description;
        $discussion->category_id = $request->category_id;

        if ($request->hasFile('picture')) {
            $discussion->picture = $request->file('picture')->store('pictures');
        }

        $discussion->save();

        return redirect()->route('home')->with('success', 'Discussion updated successfully');
    }

    public function destroy(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        if (Auth::id() !== $discussion->user_id && !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'You are not authorized to delete this discussion.');
        }

        $discussion->delete();

        return redirect()->route('home')->with('success', 'Discussion deleted successfully');
    }

    public function approve(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        if (Auth::user()->role != 1) {
            return redirect()->route('home')->with('error', 'You are not authorized to unapprove this discussion.');
        }

        $discussion->is_approved = true;
        $discussion->save();

        return redirect()->route('home')->with('success', 'Discussion approved successfully');
    }

    public function unapprove(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        if (Auth::user()->role != 1) {
            return redirect()->route('home')->with('error', 'You are not authorized to unapprove this discussion.');
        }

        $discussion->is_approved = false;
        $discussion->save();

        return redirect()->route('home')->with('success', 'Discussion unapproved successfully');
    }

    public function approveAll()
    {
        if (Auth::user()->role != 1) {
            return redirect()->route('home')->with('error', 'You are not authorized to approve all discussions.');
        }

        Discussion::where('is_approved', false)->update(['is_approved' => true]);

        return redirect()->route('home')->with('success', 'All discussions have been approved.');
    }
}
