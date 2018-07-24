@if (\Illuminate\Support\Facades\Session::has('errors'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{\Illuminate\Support\Facades\Session::get('errors')[0]}}
        {{ Session::forget('errors') }}
    </div>
@endif