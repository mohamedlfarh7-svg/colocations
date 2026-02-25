<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $colocation = $user->colocations()->wherePivot('left_at', null)->first();

        if (!$colocation) {
            return redirect()->route('colocations.index');
        }

        $query = Expense::where('colocation_id', $colocation->id);

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        $expenses = $query->with(['category', 'user'])->latest()->get();
        $categories = Category::all();

        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $colocation = $user->colocations()->wherePivot('left_at', null)->first();

        Expense::create([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'category_id' => $validated['category_id'],
            'date' => $validated['date'],
            'user_id' => $user->id,
            'colocation_id' => $colocation->id,
        ]);

        return back();
    }
}