<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Hotel;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class CountryController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        $hotels = Hotel::all();

        return view('back.countries.index', [
            'countries' => $countries,
            'hotels' => $hotels
        ]);

        //  return redirect()
        // ->route('countries-index')
        // ->with('info', 'Country was created'); 
    }

    public function show (Country $country)
    {
        $hotels = Hotel::all();
        $countries = Country::all();
        return view('back.countries.show', [
            'countries' => $countries,
            'country' => $country,
            'hotels' => $hotels
        ]);
    }
    
    public function create()
    {
        return view('back.countries.create', [

        ]);
    }


    public function store(Request $request)
    {
        $id = Country::create([
            'title' => $request->title,
            'season' => $request->season
            
        ])->id;
    
        return redirect()
        ->route('countries-index')
        ->with('ok', 'New country has been created');

    }


    public function edit(Country $country)
    {
    
        $countries = Country::all();
        return view('back.countries.edit', [
            'countries' => $countries,
            'country' => $country
        ]);
    }


    public function update(Request $request, Country $country)
    {
        $country->update([
            'title' => $request->title,
            'season' => $request->season,
            'country_id' =>$request->country_id
        ]);

        return redirect()
        ->route('countries-index')
        ->with('info', 'The country has been updated');
    }


    public function destroy(Country $country)
    {
        
         $country->delete();
        return redirect()->route('countries-index')
        ->with('info', 'The country has been deleted');
    }

}