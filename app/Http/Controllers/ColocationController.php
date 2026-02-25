<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Colocation::with('images')->get();
        return view('colocations.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colocations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColocationRequest $request)
    {
        Colocation::create($request->validated());

        return redirect()->route('colocations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $colocation->load('images');
        return view('colocations.show', compact('colocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        $colocation->update($request->validated());

        return redirect()->route('colocations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index');
    }
}
