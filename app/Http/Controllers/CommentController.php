<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all(); 
        return view('discussions.show', compact('comments')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($discussion)
    {
        $discussion = Discussion::findOrFail($discussion); // Find the discussion
        return view('comments.create', compact('discussion')); // Pass discussion to view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $discussionId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $discussion = Discussion::findOrFail($discussionId); // Find the discussion

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id(); // Get the currently authenticated user
        $comment->discussion_id = $discussion->id;
        $comment->save();

        return redirect()->route('discussions.show', $discussion->id)
                         ->with('success', 'Comment added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::findOrFail($id); // Find the comment
        return view('comments.show', compact('comment')); // Pass comment to view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id); // Find the comment
        return view('comments.edit', compact('comment')); // Pass comment to view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id); // Find the comment
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('discussions.show', $comment->discussion_id)
                         ->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id); // Find the comment
        $comment->delete();

        return redirect()->route('discussions.show', $comment->discussion_id)
                         ->with('success', 'Comment deleted successfully!');
    }
}
