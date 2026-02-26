<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ColocationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $colocations = $user->colocations()
            ->wherePivot('left_at', null)
            ->get();
            
        return view('colocations.index', compact('colocations'));
    }

    public function create()
    {
        if (Auth::user()->colocations()->wherePivot('left_at', null)->exists()) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous devez quitter votre colocation actuelle avant d\'en créer une nouvelle.');
        }

        return view('colocations.create');
    }

    public function store(StoreColocationRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->colocations()->wherePivot('left_at', null)->exists()) {
            return redirect()->route('colocations.index')
                ->with('error', 'Vous êtes déjà dans une colocation active.');
        }

        $colocation = DB::transaction(function () use ($request, $user) {
            $colocation = Colocation::create($request->validated());
            $colocation->members()->attach($user->id, ['role' => 'owner']);
            return $colocation;
        });

        return redirect()->route('colocations.show', $colocation)->with('success', 'Colocation créée !');
    }

    public function show(Colocation $colocation)
    {
        $this->authorize('view', $colocation);

        $colocation->load(['expenses.user', 'images', 'payments']);
        
        $activeMembers = $colocation->members()->wherePivot('left_at', null)->get();
        $totalExpenses = $colocation->expenses->sum('amount');
        $membersCount = $activeMembers->count();
        
        $sharePerMember = $membersCount > 0 ? $totalExpenses / $membersCount : 0;

        $balances = $activeMembers->map(function ($member) use ($sharePerMember, $colocation) {
            $paidForExpenses = $colocation->expenses->where('user_id', $member->id)->sum('amount');
            $sentPayments = $colocation->payments->where('from_user_id', $member->id)->sum('amount');
            $receivedPayments = $colocation->payments->where('to_user_id', $member->id)->sum('amount');

            return [
                'user' => $member,
                'paid' => $paidForExpenses,
                'balance' => ($paidForExpenses + $sentPayments) - ($sharePerMember + $receivedPayments),
            ];
        });

        return view('colocations.show', compact('colocation', 'balances', 'totalExpenses', 'sharePerMember'));
    }

    public function leave(Colocation $colocation)
    {
        /** @var User $user */
        $user = Auth::user();

        $colocation->load(['expenses', 'payments', 'members']);
        
        $activeMembers = $colocation->members()->wherePivot('left_at', null)->get();
        $totalExpenses = $colocation->expenses->sum('amount');
        $membersCount = $activeMembers->count();
        $sharePerMember = $membersCount > 0 ? $totalExpenses / $membersCount : 0;

        $paid = $colocation->expenses->where('user_id', $user->id)->sum('amount');
        $sent = $colocation->payments->where('from_user_id', $user->id)->sum('amount');
        $received = $colocation->payments->where('to_user_id', $user->id)->sum('amount');
        
        $balance = ($paid + $sent) - ($sharePerMember + $received);

        if ($balance < -1) {
            $user->decrement('rating');
        } else {
            $user->increment('rating');
        }

        $colocation->members()->updateExistingPivot($user->id, ['left_at' => now()]);

        return redirect()->route('colocations.index')->with('success', 'Vous avez quitté la colocation.');
    }

    public function uploadImage(Request $request, Colocation $colocation)
    {
        $this->authorize('view', $colocation);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $path = $request->file('image')->store('colocations', 'public');

        $colocation->images()->create([
            'path' => $path
        ]);

        return back()->with('success', 'Image ajoutée !');
    }

    public function edit(Colocation $colocation)
    {
        $this->authorize('update', $colocation);
        return view('colocations.edit', compact('colocation'));
    }

    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        $this->authorize('update', $colocation);
        $colocation->update($request->validated());
        return redirect()->route('colocations.show', $colocation)->with('success', 'Mise à jour réussie !');
    }

    public function destroy(Colocation $colocation)
    {
        $this->authorize('update', $colocation);
        $colocation->delete();
        return redirect()->route('colocations.index')->with('success', 'Colocation supprimée.');
    }
}