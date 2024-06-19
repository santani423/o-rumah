<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{$title}} - O-Rumah</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('android-chrome-512x512.png')}}">
    {{$css}}
    <style>
        .bg-custom {
            background-color: rgba(45, 212, 191, var(--tw-bg-opacity));
        }

        :root {
            --tw-bg-opacity: 1;
            /* Nilai default untuk opacity */
        }

        .btn-turquoise {
            background-color: #47C8C5;
            border-color: #47C8C5;
            color: white
        }
    </style>
    <link href="{{ asset('zenter/horizontal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('zenter/horizontal/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('zenter/horizontal/assets/css/style.css')}}" rel="stylesheet" type="text/css">
</head>


<body class="bg-dark">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Navigation Bar-->
    <x-Layout.Horizontal.NavBar></x-Layout.Horizontal.NavBar>
    <!-- End Navigation Bar-->
    <div class="wrapper " style="min-height: 100vh;">
        <div class="container-fluid">
            {{$body}}
        </div>
    </div>


    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    © 2024 O-Rumah.---
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->



    <!-- jQuery  -->
    <script src="{{ asset('zenter/horizontal/assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('zenter/horizontal/assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('zenter/horizontal/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('zenter/horizontal/assets/js/modernizr.min.js')}}"></script>
    <script src="{{ asset('zenter/horizontal/assets/js/waves.js')}}"></script>
    <script src="{{ asset('zenter/horizontal/assets/js/jquery.nicescroll.js')}}"></script>

    {{$js}}
    <!-- App js -->
    <script src="{{ asset('zenter/horizontal/assets/js/app.js')}}"></script>
</body>

</html>