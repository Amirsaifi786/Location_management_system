<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
   public function index()
    {
        $states = State::with('country')->orderBy('id', 'desc')->paginate(10);
        // dd($states->country->country_id);
        return view('states.index', compact('states'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('states.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_name' => 'required|string',
            'country_id' => 'required|exists:countries,id'
        ]);

        State::create($request->all());
        return redirect()->route('states.index')->with('success', 'State added successfully.');
    }
public function show(State $state)
{
    return view('states.show', compact('state'));
}

    public function edit(State $state)
    {
        $countries = Country::all();
        return view('states.edit', compact('state', 'countries'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'state_name' => 'required|string',
            'country_id' => 'required|exists:countries,id'
        ]);

        $state->update($request->all());
        return redirect()->route('states.index')->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index')->with('success', 'State deleted successfully.');
    }
}
