@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h1>Hotels List</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($hotels as $hotel)
                        <li class="list-group-item">
                            <div class="hotel-line">
                                <div class="hotel-info">
                                    <div class="photo">
                                        @if($hotel->photo)
                                        <img src="{{asset('hotels-photo') .'/t_'. $hotel->photo}}">
                                        @else
                                        <img src="{{asset('hotels-photo') .'/no.png'}}">
                                        @endif
                                    </div>
                                    <h2>{{$hotel->title}}</h2>

                                </div>
                                <div class="buttons">
                                    <a href="{{route('hotels-edit', $hotel)}}" class="btn btn-outline-success">Edit</a>
                                    <form action="{{route('hotels-delete', $hotel)}}" method="post">
                                        <button type="submit" class="btn btn-outline-danger">delete</button>
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <div class="hotel-line">No hotels</div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
