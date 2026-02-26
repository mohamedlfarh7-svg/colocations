<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Colocation;
use App\Models\User;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $invitation = $colocation->invitations()->create([
            'email' => $request->email,
            'token' => bin2hex(random_bytes(32))
        ]);

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation envoyée !');
    }

    public function accept(Invitation $invitation)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->email !== $invitation->email) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('info', 'Connectez-vous avec : ' . $invitation->email);
            }

            if ($user->colocations()->wherePivot('left_at', null)->exists()) {
                return redirect()->route('colocations.index')
                    ->with('error', 'Vous avez déjà une colocation active.');
            }
        } else {
            return redirect()->route('login')
                ->with('info', 'Veuillez vous connecter pour accepter l\'invitation.');
        }

        $colocation = $invitation->colocation;

        $colocation->members()->syncWithoutDetaching([
            $user->id => ['role' => 'member']
        ]);

        $invitation->delete();

        return redirect()->route('colocations.show', $colocation->id)
            ->with('success', 'Bienvenue dans la colocation !');
    }

    public function reject(Invitation $invitation)
    {
        $invitation->delete();
        return redirect()->route('dashboard')->with('success', 'Invitation refusée.');
    }
}