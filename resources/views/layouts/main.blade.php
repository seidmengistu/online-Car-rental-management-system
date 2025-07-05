<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.head')
    @yield('head')
</head>

<!-- Page Wrapper -->
<body class="boxed_wrapper">

    @include('components.header')

    @yield('content')

    @include('components.footer')

    @include('components.scripts')
    @yield('scripts')

</body>
</html> 