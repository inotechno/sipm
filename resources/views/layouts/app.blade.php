<!doctype html>
<html lang="en">

@include('layouts.partials.head')

<body data-topbar="dark" data-layout="horizontal" data-layout-mode="light" data-layout-width="fluid"
    data-layout-position="fixed" data-preloader="disable" data-layout-style="default">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>

        <header id="page-topbar">
            @livewire('component.layout.header', key('header-component'))
        </header>

        <div class="topnav">
            @livewire('component.layout.navbar', key('navbar-component'))
        </div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                @livewire('component.layout.footer', key('footer-component'))
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('layouts.partials.script')
</body>

<!-- Mirrored from themesbrand.com/skote/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Nov 2022 07:57:46 GMT -->

</html>
