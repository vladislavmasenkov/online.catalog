<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <link href="{{asset('//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
<div class="container">
    <div class="row row-flex app-body">
            @yield('employees-tree')

            @yield('employee-card')
    </div>
</div>
</body>
</html>
