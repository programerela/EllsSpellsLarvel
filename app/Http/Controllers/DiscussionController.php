<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Theme;
use App\Notifications\NewDiscussionNotification;

class DiscussionController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Theme $theme, Request $request)
    {
        $this->authorize('create', Discussion::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $theme->discussions()->create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);
        $newDiscussion = $theme->discussions()->latest()->first();

        $discussionsThemeFollowers = $theme->followers()->get();

        foreach ($discussionsThemeFollowers as $follower) {
            $follower->notify(new NewDiscussionNotification($theme, $newDiscussion));
        }

        return redirect()->route('theme.show', $theme)
            ->with('success', 'Discussion created successfully!');
    }

    
    public function show(Discussion $discussion)
    {
        $this->authorize('viewAny', $discussion);

        return view('discussions.show', [
            'discussion' => $discussion->load('user', 'comments.user', 'comments.replies.user'),
            'theme' => $discussion->theme,
        ]);
    }

   
    public function edit(Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        return view('discussions.edit', compact('discussion'));
    }

    
    public function update(Request $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $discussion->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('discussion.show', $discussion)
            ->with('success', 'Discussion updated successfully!');
    }

    
    public function destroy(Discussion $discussion)
    {
        $this->authorize('delete', $discussion);

        $discussion->delete();

        return redirect()->route('theme.show', $discussion->theme)
            ->with('success', 'Discussion deleted successfully!');
    }
}
