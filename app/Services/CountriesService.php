<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Country;

class CountriesService
{
  public function get()
  {
    return Country::all()->sortBy('title');
  }
}