@extends('layouts.Layout')
@section('content')

<body>
    {{ Form::open() }}
    @if(Session::has('error_message'))
        <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
        {{Session::forget('error_message')}}
    @endif
    <br/>
    
<h4>{{auth()->guard('lecturer')->user()}}</h4>
<!-- <a class="studentlink btn-danger" href="{{URL::asset('lecturer/logout')}}">Logout</a>  -->
</body>

@stop