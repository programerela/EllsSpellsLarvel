<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Theme;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (auth()->user() !== null && auth()->user()->role !== 'ADMIN') {
            return redirect('/');
        }

        $users = User::where('approve_status', 'PENDING')->get();

        return view('admin.dashboard', ['users' => $users]);
    }

    public function approve(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->update(['approve_status' => 'APPROVED']);

        return redirect()->route('dashboard');
    }

    public function reject(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->update(['approve_status' => 'REJECTED']);

        return redirect()->route('dashboard');
    }

    public function themeRequests() {

        if (auth()->user() !== null && auth()->user()->role !== 'ADMIN') {
            return redirect('/');
        }

        $themes = Theme::where('approve_status', 'PENDING')->get();

        return view('admin.theme-requests', ['themes' => $themes]);
    } 

    public function approveTheme(Request $request)
    {
        $theme = Theme::findOrFail($request->theme_id);

        $theme->update(['approve_status' => 'APPROVED']);

        return redirect()->route('admin.theme-requests');
    }

    public function rejectTheme(Request $request)
    {
        $theme = Theme::findOrFail($request->theme_id);

        $theme->update(['approve_status' => 'REJECTED']);

        return redirect()->route('admin.theme-requests');
    }

}
