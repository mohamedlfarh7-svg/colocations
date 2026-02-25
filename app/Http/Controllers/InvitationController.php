<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $invitation = Invitation::updateOrCreate(
            [
                'colocation_id' => $colocation->id, 
                'email' => $request->email
            ],
            [
                'status' => 'pending'
            ]
        );

        try {
            Mail::to($request->email)->send(new InvitationMail($colocation));
        } catch (\Exception $e) {
            // Error handling
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $colocation->members()->syncWithoutDetaching([
                $user->id => ['role' => 'member']
            ]);
        }

        return back()->with('success', 'Invitation envoyée à ' . $request->email);
    }

    public function accept(Invitation $invitation)
    {
        $user = User::where('email', $invitation->email)->first();

        if ($user && Auth::id() === $user->id) {
            $invitation->colocation->members()->syncWithoutDetaching([
                $user->id => ['role' => 'member']
            ]);
            
            $invitation->update(['status' => 'accepted']);
            
            return redirect()->route('colocations.show', $invitation->colocation_id);
        }

        return abort(403);
    }

    public function reject(Invitation $invitation)
    {
        if (Auth::user()->email === $invitation->email) {
            $invitation->update(['status' => 'rejected']);
            return back();
        }

        return abort(403);
    }
}