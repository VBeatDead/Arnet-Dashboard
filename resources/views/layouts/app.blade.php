<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/LOGO BULAT.png') }}">
    <link rel="stylesheet" href="{{ asset('css/override.css') }}">



    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.js"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Theme Color -->
    <meta name="theme-color" content="#008080">
    <!-- <meta name="theme-color" content="#0d6efd"> -->
</head>

<body style="background-color: var(--bs-gray-900);" id="home">
    <!-- CONTAINER -->
    <div class="container-fluid bd-layout p-0">
        @include('partials.header')
        @include('partials.sidebar')
        <main class="bd-main p-3 bg-light">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Main Script -->
    <script src="../js/blank.js"></script>
    <script>
        $('select').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    </script>

    
</body>

</html>
