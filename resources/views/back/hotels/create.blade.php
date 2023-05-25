@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h1>Add Hotel</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('hotels-store')}}" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Hotel title</label>
                            <input type="text" class="form-control" name="title" value={{old('title')}}>
                            <div class="form-text">Please add hotel title here</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel price</label>
                            <input type="text" class="form-control" name="price" value={{old('price')}}>
                            <div class="form-text">Please add hotel price here</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Holiday duration</label>
                            <input type="text" class="form-control" name="duration" value={{old('duration')}}>
                            <div class="form-text">Please add holiday duration here</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id">
                                <option value="0">Country list</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->title}} {{$country->season}}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Please select country</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Main hotel photo</label>
                            <input type="file" class="form-control" name="photo">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
