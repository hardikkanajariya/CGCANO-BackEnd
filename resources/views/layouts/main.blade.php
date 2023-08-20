<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Meta Tags --}}
    <title>CGCANO - Admin Panel</title>
    <!-- Application vendor css url -->
    <link rel="stylesheet" href="{{url('/')}}/assets/cssbundle/dataTables.min.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/cssbundle/daterangepicker.min.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/cssbundle/select2.min.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/css/summernote.min.css"/>

    <!-- project css file  -->
    <link rel="stylesheet" href="{{url('/')}}/assets/css/luno-style.css">
    <!-- Jquery Core Js -->
    <script src="{{url('/')}}/assets/js/plugins.js"></script>
    {{-- Styles --}}
    <script src="https://kit.fontawesome.com/cabb64bd6b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('head')
</head>

<body class="layout-1" data-luno="theme-blue">
@include('include.sidebar')
<div class="wrapper">
    @include('include.header')
    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    @include('include.footer')
</div>
{{-- Scripts --}}
<script src="{{url('/')}}/assets/js/plugins.js"></script>
<!-- Plugin Js -->
<script src="{{url('/')}}/assets/js/bundle/apexcharts.bundle.js"></script>
<script src="{{url('/')}}/assets/js/bundle/dataTables.bundle.js"></script>
<!-- Vendor Script -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://parsleyjs.org/dist/parsley.js"></script>
<script src="{{url('/')}}/assets/js/bundle/summernote.bundle.js"></script>

<script>
    // Add Parsley Validator to All Forms in the Page (For Validation)
    $(document).ready(function () {
        try {
            $('form').parsley();
        } catch (e) {
        }
        try {
            $('.select2').select2();
        } catch (e) {
        }
        try {
            $('#summernote').summernote();
        } catch (e) {
        }
    });
    @foreach($errors->all() as $error)
    Toastify({
        text: "{{$error}}",
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(to right, #ff416c, #ff4b2b)",
        className: "info"
    }).showToast();
    @endforeach

    @if(session()->has('success'))
    Toastify({
        text: "{{session()->get('success')}}",
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        className: "info"
    }).showToast();
    @endif

    @if(session()->has('error'))
    Toastify({
        text: "{{session()->get('error')}}",
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(to right, #ff416c, #ff4b2b)",
        className: "info"
    }).showToast();
    @endif
</script>

@yield('page-scripts')
@yield('components-scripts')
</body>

</html>
