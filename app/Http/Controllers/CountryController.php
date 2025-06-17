<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller

{
    // Show all countries
    public function index()
    {
        $countries = Country::orderBy('id', 'desc')->paginate(10); // paginate for UI
        return view('countries.index', compact('countries'));
    }

    // Show create form
    public function create()
    {
        return view('countries.create');
    }

    // Store new country
    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string|max:255',
            // 'sortname' => 'nullable|string|max:10',
            // 'phoneCode' => 'nullable|integer',
        ]);

        Country::create($request->all());

        return redirect()->route('countries.index')->with('success', 'Country added successfully.');
    }

    // Show edit form
    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    // Update country
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'country_name' => 'required|string|max:255',
            'sortname' => 'nullable|string|max:10',
            'phoneCode' => 'nullable|integer',
        ]);

        $country->update($request->all());

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    // Delete country
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
