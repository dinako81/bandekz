<div class="card mt-5">
    <div class="card-header">
        <h2>Countries</h2>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <div class="cat-line">
                <a href="{{route('front-index')}}">All countries</a>
            </div>
            @forelse($countries as $country)
            <li class="list-group-item">
                <div class="country-line">
                    <div class="country-info">
                        <h3><a href="{{ route('countries-show', $country->id) }}">{{$country->title}}</a></h3>

                    </div>
                </div>
            </li>
            @empty
            <li class=" list-group-item">
                <div class="country-line">No countries</div>
            </li>
            @endforelse

        </ul>
    </div>
</div>
