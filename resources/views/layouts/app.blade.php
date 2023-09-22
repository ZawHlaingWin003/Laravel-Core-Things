<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <!-- CSRF Token -->
    <meta content="{{ csrf_token() }}" name="csrf-token">

    <title>Laravel Core Things</title>

    @include('partials.styles')
    @yield('custom_styles')
</head>

<body>
    {{-- @include('sweetalert::alert') --}}

    @include('partials.header')

    <div class="container my-5">
        @yield('content')
    </div>

    @include('partials.modals')

    @include('partials.scripts')
    @yield('custom_scripts')
</body>

</html>
