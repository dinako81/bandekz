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
        

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:100',
            'season' => 'required|min:3|max:100',
            'photo' => 'sometimes|required|image|max:512',
            'gallery.*' => 'sometimes|required|image|max:512'
        ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        
        $photo = $request->photo;
        if ($photo) {
            $name = $country->savePhoto($photo);
        }
        $id = Country::create([
            'title' => $request->title,
            'season' => $request->season,
            'photo' => $name ?? null
        ])->id;

        foreach ($request->gallery ?? [] as $gallery) {
            Photo::add($gallery, $id);
        }

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
        
        if ($request->delete == 1) {
            $country->deletePhoto();
            return redirect()->back();
        }

        $photo = $request->photo;

        if ($photo) {
            $name = $country->savePhoto($photo);
            $country->deletePhoto();
            $country->update([
                'title' => $request->title,
                'colors_count' => $request->colors_count,
                'photo' => $name
            ]);
        } else {
            $country->update([
                'title' => $request->title,
                'colors_count' => $request->colors_count,
            ]);
        }

        foreach ($request->gallery ?? [] as $gallery) {
            Photo::add($gallery, $country->id);
        }

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