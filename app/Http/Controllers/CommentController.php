<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Discussion;
use App\Notifications\CommentNotification;
use App\Notifications\CommentVotedNotification;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Discussion $discussion, Request $request)
    {
        $this->authorize('create', Comment::class);

        $request->validate([
            'content' => 'required|string',
        ]);

        $discussion->comments()->create([
            'content' => $request->content,
            'discussion_id' => $discussion->id,
            'user_id' => $request->user()->id,
        ]);

        foreach ($discussion->theme->followers as $follower) {
            $follower->notify(new CommentNotification($discussion->comments->last()));
        }

        return redirect()->route('discussion.show', $discussion)
            ->with('success', 'Comment submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function vote(Comment $comment, Request $request)
    {
        if (auth()->user() === null) {
            return redirect()->route('login');
        }

        $request->validate([
            'vote' => 'required|in:-1,1',
        ]);

        $comment->usersVoted()->detach($request->user());

        $comment->usersVoted()->syncWithoutDetaching([
            $request->user()->id => ['vote' => $request->vote],
        ]);

        $userThatVoted = User::find($request->user()->id);
        $comment->user->notify(new CommentVotedNotification($comment, $userThatVoted));

        return back()->with('success', 'Vote submitted successfully!');
    }
}
