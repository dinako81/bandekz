@if (Session::has('ok'))
<div class="alert alert-success">
    {{ Session::get('ok') }}
</div>
@endif
@if (Session::has('info'))
<div class="alert alert-info">
    {{ Session::get('info') }}
</div>
@endif
@if (Session::has('warn'))
<div class="alert alert-danger">
    {{ Session::get('warn') }}
</div>
@endif
