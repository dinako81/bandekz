<form action="{{route('front-vote', $hotel)}}" method="post">
    <div class="stars">
        @for($i = 1; $i < 6; $i++) <input name="star[]" type="checkbox" id="_{{$i.'-'.$hotel->id}}" data-star="{{$i}}" {{$hotel->rate >= $i ? ' checked' : ''}}>
            <label class="star{{ ceil($hotel->rate) == $i && $hotel->rate != $i ? ' half' : ''}}" for="_{{$i.'-'.$hotel->id}}"></label>
            @endfor
            <div class="result">
                @if($hotel->rate)
                {{$hotel->rate}} <span>({{$hotel->votes}} votes)</span>
                @else($condition)
                <span>No rating yet</span>
                @endif
            </div>
            @if($hotel->showVoteButton)
            <button type="submit" class="btn btn-info">vote</button>
            @endif
            @csrf
            @method('put')
    </div>
</form>
