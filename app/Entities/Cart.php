<?php

namespace App\Entities;

use App\Models\Hotel;

class Cart
{

    private $hotels;

    public function __construct(array $cart) 
    {
        $hotelsId = array_keys($cart);
        $this->hotels = Hotel::whereIn('id', $hotelsId)->get();
        $this->hotels = $this->hotels->map(function($p) use ($cart) {
            $p->count = $cart[$p->id];
            return $p;
        });
    }


    public function total()
    {
        return $this->hotels->reduce(function ($carry, $item) {
            return $carry + $item->count * $item->price;
        }, 0);
    }

    public function hotels()
    {
        return $this->hotels;
    }

}