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
    
        return redirect()->route('countries-index');

    }


    public function edit(Country $country)
    {
        return view('back.countries.edit', [
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

        return redirect()->route('countries-index');
    }


    public function destroy(Country $country)
    {
        
        if ($country->gallery->count()) {
            foreach ($country->gallery as $gal) {
                $gal->deletePhoto();
            }
        }
        
        if ($country->photo) {
            $country->deletePhoto();
        }
        
        $country->delete();
        return redirect()->route('countries-index');
    }


    public function destroyPhoto(Photo $photo)
    {
        $photo->deletePhoto();
        return redirect()->back();
    }

}