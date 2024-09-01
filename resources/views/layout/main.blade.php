<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>


{{--    link bootstrap css--}}
    <link rel="stylesheet" href="{{asset('storage/bootstrap/css/bootstrap.min.css')}}">
    <style>
        body{
            font-family: "Inter", "Helvetica Neue", sans-serif!important;
        }
    </style>
    @yield("style")

</head>
<body>

@auth
    @include("layout.nav")
@endauth
    <main class="container min-vh-100 d-flex align-items-center flex-column justify-content-start">
        @yield("content")
    </main>

<script src="{{asset("storage/bootstrap/js/bootstrap.min.js")}}"></script>
    @yield("script")

</body>
</html>
