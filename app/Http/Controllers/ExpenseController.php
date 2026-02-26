<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private $categories = ['Alimentation', 'Loyer', 'Transport', 'Divertissement', 'Autres'];

    public function index(Colocation $colocation)
    {
        $expenses = $colocation->expenses()->with('user')->latest()->get();
        $categories = $this->categories;
        return view('expenses.index', compact('colocation', 'expenses', 'categories'));
    }

    public function store(ExpenseRequest $request, Colocation $colocation)
    {
        $colocation->expenses()->create(array_merge($request->validated(), [
            'user_id' => Auth::id(),
            'date' => now(),
        ]));

        return redirect()->route('expenses.index', $colocation)->with('success', 'Ajouté !');
    }

    public function update(ExpenseRequest $request, Colocation $colocation, Expense $expense)
    {
        $expense->update($request->validated());
        return redirect()->route('expenses.index', $colocation)->with('success', 'Modifié !');
    }

    public function destroy(Colocation $colocation, Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index', $colocation)->with('success', 'Supprimé !');
    }
}