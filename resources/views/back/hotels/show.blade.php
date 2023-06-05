@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-12">
            <div class="card mt-5">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <ul class="list-group">

                        <li class="list-group-item">
                            <div class="hotel">
                                <div class="hotel-info">

                                    ******
                                </div>
                                <div class="hotel-info">
                                    <h2><i>Hotels:</i></h2>
                                    @foreach($hotels as $hotel)
                                    <h3>{{$hotel->title}}</h3>
                                    <h3>{{$hotel->duration}}</h3>
                                    <h3>{{$hotel->price}}</h3>
                                    @endforeach
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
