@extends('layouts.app')

@section('head')
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection



@section('content')
    <div class="container">
        <div class="row row-flex app-body">
            @yield('employees-tree')

            @yield('employee-card')
        </div>
    </div>
@endsection

