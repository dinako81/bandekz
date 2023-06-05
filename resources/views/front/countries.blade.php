@inject('countries', App\Services\CountriesService::class)
<div class="card mt-5">
    <div class="card-header">
        <h2>Countries</h2>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <div class="country-line">
                <a href="{{route('front-index')}}">All countries</a>
            </div>
            @forelse($countries->get() as $country)
            <div class="country-line">
                <a href="{{route('countries-show', $country)}}">{{$country->title}}</a>
            </div>
            @empty
            <li class="list-group-item">
                <div class="country-line">No categories</div>
            </li>
            @endforelse
        </ul>
    </div>
</div>
