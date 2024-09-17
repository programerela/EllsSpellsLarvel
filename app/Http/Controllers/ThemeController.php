<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Theme;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Theme::class);

        //$themes = Theme::where('approve_status', 'APPROVED')->get();
        $themes = Theme::where('approve_status', 'APPROVED')
            ->where(function ($query) {
                // if (auth()->check()) {
                //     $query->whereDoesntHave('blockedUsers', fn ($query) => $query->where('user_id', auth()->id()));
                // }
            })
            ->get();

        if (auth()->check()) {
            $user = User::find(auth()->user() !== null && auth()->user()->getAuthIdentifier());
            $followedThemesFromWhichUserIsNotBlocked = $user->followedThemes()->get(); //->get();
                // ->whereDoesntHave('blockedUsers', function ($query) {
                //     $query->where('user_id', auth()->id());
                // })
                // ->get();
        }

        //dd($followedThemesFromWhichUserIsNotBlocked);

        $followedThemes = DB::table('themes')
        ->join('theme_user', 'themes.id', '=', 'theme_user.theme_id')
        ->where('theme_user.user_id', auth()->id())
        ->get();

        //dd($followedThemes);
        $followedThemes = Theme::hydrate($followedThemes->toArray());

        return view('theme.index', ['themes' => $themes, 'userFollowedThemes' => $followedThemes ?? []]);
    }

    public function follows() {

        $this->authorize('viewAny', Theme::class);

        //$themes = Theme::where('approve_status', 'APPROVED')->get();
        
        if (auth()->check()) {
            $user = User::find(auth()->user() !== null && auth()->user()->getAuthIdentifier());
            //$followedThemesFromWhichUserIsNotBlocked = $user->followedThemes()->get(); //->get();
                // ->whereDoesntHave('blockedUsers', function ($query) {
                //     $query->where('user_id', auth()->id());
                // })
                // ->get();
        }

        //dd($followedThemesFromWhichUserIsNotBlocked);

        $followedThemes = DB::table('themes')
        ->join('theme_user', 'themes.id', '=', 'theme_user.theme_id')
        ->where('theme_user.user_id', auth()->id())
        ->get();

        //dd($followedThemes);
        $followedThemes = Theme::hydrate($followedThemes->toArray());
        dd($followedThemes);

        //return view('theme.index', ['themes' => $themes, 'userFollowedThemes' => $followedThemes ?? []]);
        return view('theme.followed', ['followedThemes' => $followedThemes ?? []]);
    }

    
    public function create()
    {
        $this->authorize('create', Theme::class);

        return view('theme.create');
    }

   
    public function store(Request $request)
    {
        $this->authorize('create', Theme::class);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'picture' => 'required'
        ]);

        $response = cloudinary()->upload($request->file('picture')->getRealPath(), [
            'verify' => false
        ])->getSecurePath();

        Theme::create([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $response,
            'user_id' => $request->user()->id,
        ]);



        return redirect()->route('theme.index')
            ->with('success', 'Theme created successfully! Wait for approval.');
    }

    
    public function show(Theme $theme)
    {
        $this->authorize('view', $theme);

        return view('theme.show', ['theme' => $theme->load('discussions')]);
    }

    
    public function edit(Theme $theme)
    {
        $this->authorize('update', $theme);

        return view('theme.edit', ['theme' => $theme]);
    }

    
    public function update(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $theme->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('theme.show', $theme)
            ->with('success', 'Theme updated successfully!');
    }

    
    public function destroy(Theme $theme)
    {
        $this->authorize('delete', $theme);

        $theme->delete();

        return redirect()->route('theme.index')
            ->with('success', 'Theme deleted successfully!');
    }

    
    public function follow(Theme $theme, Request $request)
    {
        $theme->followers()->attach($request->user());

        return redirect()->route('theme.show', $theme);
    }

    
    public function unfollow(Theme $theme, Request $request)
    {
        $theme->followers()->detach($request->user());

        return redirect()->route('theme.show', $theme);
    }

    public function blockUser(Request $request, Theme $theme, User $user)
    {
        $this->authorize('block', $theme);

        $theme->followers()->detach($user);

        $theme->blockedUsers()->attach($user);

        return back();
    }

    public function unblockUser(Request $request, Theme $theme, User $user)
    {
        $this->authorize('block', $theme);

        $theme->blockedUsers()->detach($user);

        return back();
    }
}