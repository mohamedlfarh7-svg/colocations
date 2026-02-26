<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $colocation->payments()->create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Remboursement enregistré !');
    }
}