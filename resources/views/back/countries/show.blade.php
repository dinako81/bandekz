@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h1>Stories List</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">

                        <li class="list-group-item">
                            <div class="story">
                                <div class="story-info">
                                    <h2>{{$story->title}}</h2>
                                    {{$story->season}}
                                </div>





                                <div class="mb-3" data-gallery="0">
                                    <label class="form-label">Gallery photo <span class="rem">X</span></label>
                                    <input type="file" class="form-control">
                                </div>

                                <a href="{{route('front-gallery', $story)}}" class="btn btn-outline-success">More gallery photos</a>

                                {{-- @if(Auth::user()->role < 5)  --}}
                                <div class="buttons">
                                    <a href="{{route('stories-edit', $story)}}" class="btn btn-outline-success">Edit Story</a>
                                    <form action="{{route('stories-delete', $story)}}" method="post">
                                        <button type="submit" class="btn btn-outline-danger">Delete Story</button>
                                        @csrf
                                        @method('delete')
                                    </form>
                                    {{-- @endif --}}
                                </div>
                                @include('front.stars')

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

                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
