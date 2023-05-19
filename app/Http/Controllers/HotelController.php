<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
// use App\Models\Photo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class HotelController extends Controller
{

    public function index()
    {
        $hotels = Hotel::all();

        return view('back.hotels.index', [
            'hotels' => $hotels
        ]);
    }


    public function create()
    {
        
        $hotels = Hotel::all();
        
        return view('back.hotels.create', [
            'hotels' => $hotels
        ]);
    }

    // public function colors(Request $request)
    // {

    //     $colorsCount = Country::where('id', $request->country)->first()->colors_count;

    //     $html = view('back.hotels.colors')
    //     ->with(['colorsCount' => $colorsCount])
    //     ->render();

    //     return response()->json([
    //         'html' => $html,
    //         'message' => 'OK',
    //     ]);
    // }

    // public function colorName(Request $request, ColorNamingService $cns)
    // {
    //     return response()->json([
    //         'name' => $cns->nameIt($request->color),
    //         'message' => 'OK',
    //     ]);
    // }


    public function store(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:100',
            'price' => 'required|min:3|max:100',
            'photo' => 'sometimes|required|image|max:512',
            'duration' => 'required|min:3|max:100',
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
        $id = Hotel::create([
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'country_id' =>$request->country_id,
            'photo' => $name ?? null
        ])->id;

        foreach ($request->gallery ?? [] as $gallery) {
            Photo::add($gallery, $id);
        }

        return redirect()->route('hotels-index');


  

        // foreach ( $request->color as $index => $color) {
        //     Color::create([
        //         'title' => $request->name[$index],
        //         'hex' => $color,
        //         'hotel_id' => $id
        //     ]);
        // }

        return redirect()->route('hotels-index');
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
        $hotel->delete();
        return redirect()->route('hotels-index');
    }
}