<!doctype html>
<html lang="en">

@include('layouts.partials.head')

<body data-sidebar="dark" data-layout-mode="horizontal">

    {{$slot}}
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    @include('layouts.partials.script')
</body>

</html>
