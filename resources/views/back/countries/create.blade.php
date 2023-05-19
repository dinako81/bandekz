@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h1>Add Country</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('countries-store')}}" method="post" enctype="multipart/form-data">
                        <div class="col-9">
                            <div class="mb-3">
                                <label class="form-label">Country title</label>
                                <input type="text" class="form-control" name="title" value={{old('title')}}>
                                <div class="form-text">Please add country title here</div>
                            </div>
                        </div>

                        <div class="col-9">
                            <div class="mb-3">
                                <label class="form-label">Country season</label>
                                <input type="text" class="form-control" name="season" value={{old('season')}}>
                                <div class="form-text">Please add country season</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
