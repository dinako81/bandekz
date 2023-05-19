@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h1>hotels List</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($hotels as $hotel)
                        <li class="list-group-item">
                            <div class="hotels-list">
                                <div class="hotel">
                                    <div class="title-price">
                                        <div>
                                            <h2>{{$hotel->title}}<span>{{$hotel->price}} EUR</span></h2>

                                        </div>
                                        {{-- @if(Auth::user()->role < 5)  --}}
                                        <div class="buttons">
                                            <a href="{{route('hotels-edit', $hotel)}}" class="btn btn-outline-success">Edit</a>
                                            <form action="{{route('hotels-delete', $hotel)}}" method="post">
                                                <button type="submit" class="btn btn-outline-danger">delete</button>
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                        {{-- @endif --}}
                                    </div>

                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <div class="cat-line">No hotels</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
