<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
   public function getStates($country_id)
{
    return response()->json(State::where('country_id', $country_id)->get());
}


    // public function index()
    // {
    //     $cities = City::with('state')->orderBy('id', 'desc')->paginate(10);
    //     return view('cities.index', compact('cities'));
    // }
    public function index(Request $request)
{
    $query = City::with('state');

    if ($request->has('search') && $request->search != '') {
        $searchTerm = $request->search;

        $query->where('city_name', 'like', '%' . $searchTerm . '%')
              ->orWhereHas('state', function ($q) use ($searchTerm) {
                  $q->where('state_name', 'like', '%' . $searchTerm . '%');
              });
    }

    $cities = $query->paginate(10)->withQueryString(); // Keep search in pagination

    return view('cities.index', compact('cities'));
}



    public function create()
    {
        $states = State::all();
        return view('cities.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string',
            'state_id' => 'required|exists:states,id'
        ]);

        City::create($request->all());
        return redirect()->route('cities.index')->with('success', 'City added successfully.');
    }

    public function edit(City $city)
    {
        $states = State::all();
        return view('cities.edit', compact('city', 'states'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'city_name' => 'required|string',
            'state_id' => 'required|exists:states,id'
        ]);

        $city->update($request->all());
        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }
}