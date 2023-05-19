<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
// use App\Models\Color;
use Illuminate\Http\Request;
use App\Services\ColorNamingService;

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
        
        $countries = Country::all();
        
        return view('back.hotels.create', [
            'countries' => $countries
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
        $id = Hotel::create([
            'title' => $request->title,
            'price' => $request->price,
            'photo' => $request->photo,
            'duration' => $request->duration,
            'country_id' =>$request->country_id
        ])->id;

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
        $hotel->update([
            'title' => $request->title,
            'price' => $request->price,
            'photo' => $request->photo,
            'duration' => $request->duration,
            'country_id' =>$request->country_id
        ]);

        // $hotel->color()->delete();

        // foreach ($request->color as $index => $color) {
        //     Color::create([
        //         'title' => $request->name[$index],
        //         'hex' => $color,
        //         'hotel_id' => $hotel->id
        //     ]);
        // }

        return redirect()->route('hotels-index');
    }


    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels-index');
    }
}