@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3">
            <div class="card mt-5">
                <div class="card-header">
                    <h2>Countries:</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <div class="story-line">
                            <a href="{{route('countries-index')}}">All countries</a>
                        </div>
                        @forelse($countries as $country)
                        <a href="{{route('countries-show', $country)}}">
                            <h2>{{$country->title}}</h2>
                        </a>
                        @empty
                        <li class="list-group-item">
                            <div class="story-line">No countries</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-9">
            <div class=" card mt-5">
                <div class="col-9 card-header">
                    <h1>Hotels List</h1>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @forelse($hotels as $hotel)
                        <li class="list-group-item">

                            <div class="stories-list">

                                <div class="story">
                                    <div class="story-info">
                                        <h2>{{$hotel->title}}</h2>
                                        {{$hotel->duration}}
                                        {{$hotel->price}}
                                    </div>

                                    <div class="photo">
                                        @if($hotel->photo)
                                        <img src="{{asset('stories-photo') .'/t_'. $hotel->photo}}">
                                        @else
                                        <img src="{{asset('stories-photo') .'/no.jpg'}}">
                                        @endif
                                    </div>
                                    <div class="mb-3" data-gallery="0">
                                        <label class="form-label">Gallery photo <span class="rem">X</span></label>
                                        <input type="file" class="form-control">
                                    </div>




                                    {{-- @if(Auth::user()->role < 5)  --}}
                                    <div class="buttons mx-auto">
                                        <a href="{{route('front-gallery', $country)}}" class="btn btn-outline-success">More gallery photos</a>
                                        <a href="{{route('stories-edit', $country)}}" class="btn btn-outline-success">Edit country</a>
                                        <form action="{{route('stories-delete', $country)}}" method="post">
                                            <button type="submit" class="btn btn-outline-danger">Delete country</button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                        {{-- @endif --}}


                                        <div class="story-amount">
                                            <div>
                                                <span> Goal: {{$story->totalamount}} EUR</span>
                                                <span> Donated: {{$story->donatedamount}} EUR</span>
                                                <span> Rest: {{$story->restamount}} EUR</span>
                                            </div>

                                        </div>
                                        <div class="buttons">
                                            <form action="{{route('stories-donateamount', $story)}}" method="post">
                                                <input type="text" class="form-control brown" name="donatedamount" value="">
                                                <button type="submit" class="btn btn-outline-dark brown">Donate</button>
                                                @csrf
                                                @method('put')
                                            </form>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <div class="cat-line">No storys</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
