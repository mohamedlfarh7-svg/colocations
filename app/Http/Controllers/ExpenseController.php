<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Http\Requests\ExpenseRequest;
use App\Notifications\ExpenseAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpenseController extends Controller
{
    use AuthorizesRequests;

    private $categories = ['Alimentation', 'Loyer', 'Transport', 'Divertissement', 'Autres'];

    public function index(Colocation $colocation)
    {
        $this->authorize('view', $colocation);
        $expenses = $colocation->expenses()->with('user')->latest()->get();
        $categories = $this->categories;
        return view('expenses.index', compact('colocation', 'expenses', 'categories'));
    }

    public function store(ExpenseRequest $request, Colocation $colocation)
    {
        $this->authorize('view', $colocation);

        $expense = $colocation->expenses()->create(array_merge($request->validated(), [
            'user_id' => Auth::id(),
            'date' => now(),
        ]));

        $others = $colocation->members()->where('users.id', '!=', Auth::id())->get();
        Notification::send($others, new ExpenseAdded($expense));

        return redirect()->route('expenses.index', $colocation)->with('success', 'Dépense ajoutée !');
    }

    public function update(ExpenseRequest $request, Colocation $colocation, Expense $expense)
    {
        $this->authorize('view', $colocation);
        if ($expense->user_id !== Auth::id()) {
            return back()->with('error', 'Action non autorisée.');
        }
        $expense->update($request->validated());
        return redirect()->route('expenses.index', $colocation)->with('success', 'Modifiée !');
    }

    public function destroy(Colocation $colocation, Expense $expense)
    {
        $this->authorize('view', $colocation);
        if ($expense->user_id !== Auth::id()) {
            return back()->with('error', 'Action non autorisée.');
        }
        $expense->delete();
        return redirect()->route('expenses.index', $colocation)->with('success', 'Supprimée !');
    }
}