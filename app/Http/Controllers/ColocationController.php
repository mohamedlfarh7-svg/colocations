<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $colocations = $user->memberships()
            ->whereNull('left_at')
            ->with('colocation')
            ->get();
            
        return view('colocations.index', compact('colocations'));
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(StoreColocationRequest $request)
    {
        DB::transaction(function () use ($request) {
            $colocation = Colocation::create($request->validated());
            $colocation->members()->attach(Auth::id(), ['role' => 'owner']);
        });

        return redirect()->route('colocations.index');
    }

    public function show(Colocation $colocation)
    {
        $colocation->load(['members', 'expenses.user']);

        $totalExpenses = $colocation->expenses->sum('amount');
        $activeMembersCount = $colocation->members()->whereNull('left_at')->count();
        $sharePerMember = $activeMembersCount > 0 ? $totalExpenses / $activeMembersCount : 0;

        $balances = $colocation->members->map(function ($member) use ($sharePerMember) {
            $paidByHim = $member->expenses()->sum('amount');
            return [
                'user' => $member,
                'balance' => $paidByHim - $sharePerMember,
            ];
        });

        return view('colocations.show', compact('colocation', 'balances', 'totalExpenses'));
    }

    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        $colocation->update($request->validated());
        return redirect()->route('colocations.index');
    }

    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index');
    }
}