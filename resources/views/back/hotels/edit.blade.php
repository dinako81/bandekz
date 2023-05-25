@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card mt-5">
                <div class="card-header">
                    <h1>Edit Hotel</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('hotels-update', $hotel)}}" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Hotel title</label>
                            <input type="text" class="form-control" name="title" value="{{old('title', $hotel->title)}}">
                            <div class="form-text">Please add hotel title here</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel price</label>
                            <input type="text" class="form-control" name="price" value={{old('price', $hotel->price)}}>
                            <div class="form-text">Please add hotel price here</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Holiday duration</label>
                            <input type="text" class="form-control" name="duration" value={{old('duration', $hotel->duration)}}>
                            <div class="form-text">Please add holiday duration here</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id">
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->title }} {{ $country->season }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Please select country</div>
                        </div>

                        <div class="mb-3">
                            <div class="container">
                                <div class="row">
                                    <div class="col-4">
                                        @if($hotel->photo)
                                        <img src="{{asset('hotels-photo') .'/t_'. $hotel->photo}}">
                                        @else
                                        <img src="{{asset('hotels-photo') .'/no.png'}}">
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <label class="form-label">Main hotel photo</label>
                                        <input type="file" class="form-control" name="photo">
                                        <button type="submit" name="delete" value="1" class="mt-2 btn btn-danger">Delete photo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" data-gallery="0">
                            <label class="form-label">Gallery photo <span class="rem">X</span></label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="gallery-inputs">

                        </div>

                        <button type="button" class="btn btn-secondary --add--gallery">add gallery photo</button>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        @csrf
                        @method('put')
                    </form>

                    <ul class="list-group mt-5">
                        @foreach($hotel->gallery as $photo)
                        <li class="list-group-item">
                            <form action="{{route('hotels-delete-photo', $photo)}}" method="post">
                                <div class="gallery">
                                    <img src="{{asset('hotels-photo') .'/'. $photo->photo}}">
                                    <button type="submit" class="m-5 btn btn-danger">Delete photo</button>
                                </div>
                                @csrf
                                @method('delete')
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
