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
        return view('colocations.create');
    }

    public function store(StoreColocationRequest $request)
    {
        $colocation = DB::transaction(function () use ($request) {
            $colocation = Colocation::create($request->validated());
            $colocation->members()->attach(Auth::id(), ['role' => 'owner']);
            return $colocation;
        });

        return redirect()->route('colocations.show', $colocation);
    }

    public function show(Colocation $colocation)
    {
        $this->authorize('view', $colocation);

        $colocation->load(['members', 'expenses.user']);

        $totalExpenses = $colocation->expenses->sum('amount');
        $activeMembers = $colocation->members()->wherePivot('left_at', null)->get();
        $membersCount = $activeMembers->count();
        
        $sharePerMember = $membersCount > 0 ? $totalExpenses / $membersCount : 0;

        $balances = $activeMembers->map(function ($member) use ($sharePerMember, $colocation) {
            $paidByHim = $colocation->expenses->where('user_id', $member->id)->sum('amount');
            return [
                'user' => $member,
                'paid' => $paidByHim,
                'balance' => $paidByHim - $sharePerMember,
            ];
        });

        return view('colocations.show', compact('colocation', 'balances', 'totalExpenses', 'sharePerMember'));
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
        return redirect()->route('colocations.show', $colocation);
    }

    public function destroy(Colocation $colocation)
    {
        $this->authorize('update', $colocation);
        $colocation->delete();
        return redirect()->route('colocations.index');
    }
}