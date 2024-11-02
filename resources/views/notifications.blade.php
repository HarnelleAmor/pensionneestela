@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')

@section('content')
    <div class="container-fluid">
        
    </div>
@endsection