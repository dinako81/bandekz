<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
use App\Models\Photo;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class HotelController extends Controller
{

    public function index(Request $request)
    {
        $hotels = Hotel::all();
        $photos = Photo::all();

        return view('back.hotels.index', [
            'hotels' => $hotels,
            'photos' => $photos,
          
        ]);
    }

    public function create()
    {
        $countries = Country::all();
        $hotels = Hotel::all();
        
        return view('back.hotels.create', [
            'hotels' => $hotels,
            'countries' => $countries,
        ]);

        with('info', 'Hotel was created'); 

    }

    

    public function store(Request $request, Hotel $hotel)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:100',
            'price' => 'required',
            'duration' => 'required',
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
            $name = $hotel->savePhoto($photo);
        }
        $id = Hotel::create([
            'country_id' => $request->country_id,
            'title' => $request->title,
            'price'=> $request->price,
            'duration'=> $request->duration,
            'photo' => $name ?? null
        ])->id;

        foreach ($request->gallery ?? [] as $gallery) {
            Photo::add($gallery, $id);
        }

        return redirect()
        ->route('hotels-index');
       
    }

    public function show(Hotel $hotel)
    {
        //
    }


    public function edit(Hotel $hotel)
    {
        $countries = Country::all();
        
        return view('back.hotels.edit', [
            'hotel' => $hotel,
            'countries' => $countries
        ]);
    }


    public function update(Request $request, Hotel $hotel)
    {
        if ($request->delete == 1) {
            $hotel->deletePhoto();
            return redirect()->back();
        }

        $photo = $request->photo;

        if ($photo) {
            $name = $hotel->savePhoto($photo);
            $hotel->deletePhoto();
            $hotel->update([
                'title' => $request->title,
                'price' => $request->price,
                'photo' => $request->photo,
                'duration' => $request->duration,
                'country_id' =>$request->country_id,
            ]);
        } else {
            $hotel->update([
                'title' => $request->title,
                'price' => $request->price,
                'duration' => $request->duration,
                'country_id' =>$request->country_id,
                
            ]);
        }

        foreach ($request->gallery ?? [] as $gallery) {
            Photo::add($gallery, $hotel->id);
        }
        return redirect()->route('hotels-index');
    }


    public function destroy(Hotel $hotel)
    {
        if ($hotel->gallery->count()) {
            foreach ($hotel->gallery as $gal) {
                $gal->deletePhoto();
            }
        }
        
        if ($hotel->photo) {
            $hotel->deletePhoto();
        }
        
        $hotel->delete();
        return redirect()
        ->route('hotels-index');
        
    }

    public function destroyPhoto(Photo $photo)
    {
        $photo->deletePhoto();
        
        return redirect() -> back();
        
    }
}