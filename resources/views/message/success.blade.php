@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{\Illuminate\Support\Facades\Session::get('success')}}
        {{ Session::forget('success') }}
    </div>
@endif