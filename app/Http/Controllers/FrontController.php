<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Country;

use App\Models\Order;

use Barryvdh\DomPDF\Facade\Pdf;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::all();
        $countries = Country::all();

        $sort = $request->sort ?? '';
        $filter = $request->filter ?? '';

        $hotels = match($filter) {
            'country' => function ($country) {
                return Hotel::whereHas('country', function ($query) use ($country) {
                    $query->where('name', $country);
                })->get();
            },
            default => Hotel::all(),
        };

        $hotels = match($sort) {
            'price_0-50' => $hotels->orderBy('price'),
            'price_51-100' => $hotels->orderBy('price'),
            'price_101-500' => $hotels->orderBy('price'),
            'price_501-...' => $hotels->orderBy('price'),
            default => $hotels
        };

        $request->session()->put('last-hotelt-view', [
            'sort' => $sort,
            'filter' => $filter
        ]);

        $hotels->map(function($p) use ($request) {

            //VOTES
            if (!$request->user()) {
                $showVoteButton = false;
            } else {
                $rates = collect($p->rates);
                $showVoteButton = $rates->first(fn($r) => $r['userId'] == $request->user()->id) ? false : true;
            }
            $p->votes = count($p->rates);
            $p->showVoteButton = $showVoteButton;

            // // TAGS
            // $tagsId = $p->hotelTag->pluck('tag_id')->all();
            // $tags = Tag::whereIn('id', $tagsId)->get();
            // $p->tags = $tags;

        });

        return view('front.index', [
            'hotels' => $hotels,
            'countries' => $countries,
            'sortSelect' => Hotel::SORT,
            'sort' => $sort,
            'filterSelect' => Hotel::FILTER,
            'filter' => $filter,
        ]);
    }

    // public function getTagsList(Request $request)
    // {
    //     $tag = $request->t ?? '';

    //     if ($tag) {
    //         $tags = Tag::where('title', 'like', '%'.$tag.'%')
    //         ->limit(5)
    //         ->get();
    //     } else {
    //         $tags = [];
    //     }
        

    //     $html = view('front.tag-search-list')->with(['tags' => $tags])->render();
        
    //     return response()->json([
    //         'tags' => $html,
    //     ]);
    // }

    // public function addNewTag(Request $request, Hotel $hotel)
    // {
    //     $title = $request->tag ?? '';

    //     if (strlen($title) < 3) {
    //         return response()->json([
    //             'message' => 'Invalid tag title',
    //             'status' => 'error'
    //         ]);
    //     }

    //     $tag = Tag::where('title', $title)->first();

    //     if (!$tag) {

    //         $tag = Tag::create([
    //             'title' => $title
    //         ]);
    //     }


    //     $tagsId = $hotel->hotelTag->pluck('tag_id')->all();
        
    //     if (in_array($tag->id, $tagsId)) {
    //         return response()->json([
    //             'message' => 'Tag exists',
    //             'status' => 'error'
    //         ]);
    //     }

    //     HotelTag::create([
    //         'tag_id' => $tag->id,
    //         'hotel_id' => $hotel->id
    //     ]);


    //     return response()->json([
    //         'message' => 'Tag added',
    //         'status' => 'ok',
    //         'tag' => $tag->title,
    //         'id' => $tag->id,
    //     ]);


    // }

    // public function deleteTag(Request $request, Hotel $hotel)
    // {
    //     $tagId = $request->tag ?? 0;

    //     $tag = Tag::find($tagId);

    //     if (!$tag) {
    //         return response()->json([
    //             'message' => 'Invalid tag id',
    //             'status' => 'error'
    //         ]);
    //     }

    //     $hotelTag = HotelTag::where('hotel_id', $hotel->id)
    //     ->where('tag_id', $tag->id)->first();

    //     $hotelTag->delete();
    //     return response()->json([
    //         'message' => 'Tag removed',
    //         'status' => 'ok',
    //         'tag' => $tag->title,
    //         'id' => $tag->id,
    //     ]);


    // }

    // public function addTag(Request $request, Potel $hotel)
    // {
    //     $tagId = $request->tag ?? 0;

    //     $tag = Tag::find($tagId);

    //     if (!$tag) {
    //         return response()->json([
    //             'message' => 'Invalid tag id',
    //             'status' => 'error'
    //         ]);
    //     }

    //     $tagsId = $hotel->hotelTag->pluck('tag_id')->all();
        
    //     if (in_array($tagId, $tagsId)) {
    //         return response()->json([
    //             'message' => 'Tag exists',
    //             'status' => 'error'
    //         ]);
    //     }

    //     HotelTag::create([
    //         'tag_id' => $tagId,
    //         'hotel_id' => $hotel->id
    //     ]);


    //     return response()->json([
    //         'message' => 'Tag added',
    //         'status' => 'ok',
    //         'tag' => $tag->title,
    //         'id' => $tag->id,
    //     ]);
    // }

   

    public function showHotel(Hotel $hotel)
    {
        return view('front.hotels', [
            'hotel' => $hotel,
        ]);
    }

    public function showCountry(Country $country)
    {
        return view('front.countries', [
            'country' => $country,
        ]);
    }

    public function orders(Request $request)
    {

      
        
        $orders = $request->user()->order;

        // $orders = Order::all();


        return view('front.orders', [
            'orders' => $orders,
            'status' => Order::STATUS
        ]);
    }

    public function download(Order $order)
    {


        $hotelNames = array_map(fn($p) => $p['title'], $order->hotels);

        $hotels = Hotel::whereIn('title', $hotelNames)->get();

        return view('front.pdf',[
                'order' => $order,
                'hotels' => $hotels,
        ]);

        $pdf = Pdf::loadView('front.pdf',[
            'order' => $order,
            'hotels' => $hotels,
        ]);

        return $pdf->download('order-'.$order->id.'.pdf');
    }

    public function vote(Request $request, Hotel $hotel)
    {
        if ($request->user()) {
            $userId = $request->user()->id;
            $rates = collect($hotel->rates);

            if (!$rates->first(fn($r) => $r['userId'] == $userId) && $request->star) {
                $stars = count($request->star);
                $userRate = [
                    'userId' => $userId,
                    'rate' => $stars
                ];
                $rates->add($userRate);
                $rate = round($rates->sum('rate') / $rates->count(), 2);

                $hotel->update([
                    'rate' => $rate,
                    'rates' => $rates,
                ]);
            }

            return redirect()->back();
        }
        
    }

}