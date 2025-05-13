<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
    @include('partials.links')

</head>

<body>
    @include('partials.navbar')

    <div class="container">
        @include('partials.allerts')
    </div>
    @yield('content')

    @include('partials.footer')
    @include('partials.scripts')

</body>

</html>
