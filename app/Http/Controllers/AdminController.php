<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $colocationsCount = Colocation::count();
        $users = User::latest()->paginate(10);

        return view('admin.dashboard', compact('usersCount', 'colocationsCount', 'users'));
    }

    public function toggleBan(User $user)
    {
        if (Auth::id() === $user->id) {
            return back();
        }

        $user->update([
            'banned_at' => $user->banned_at ? null : now()
        ]);

        return back();
    }
}