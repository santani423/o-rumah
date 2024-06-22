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

        .footer {
            padding: 23px 0;
        }
    </style>
    <link href="{{ asset('zenter/horizontal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('zenter/horizontal/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('zenter/horizontal/assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

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
    <div class="wrapper mb-6" style="min-height: 100vh;">
        <div class="container-fluid">
            {{$body}}

        </div>

    </div>

    <div class="bg-white">
        <section class="container-fluid">
            <!--Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">o-Rumah</h6>
                    <p>O-Rumah adalah perusahaan periklanan terkemuka yang berdedikasi untuk menciptakan solusi
                        pemasaran yang inovatif dan berdampak. Kami membantu bisnis terhubung dengan audiens mereka
                        melalui strategi periklanan yang kreatif dan efektif.</p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Follow us</h6>

                    <!-- Social buttons -->
                    <div class="social-buttons">
                        <!-- Facebook -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="#!"
                            role="button"><i class="fab fa-facebook-f"></i></a>
                        <!-- Twitter -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee" href="#!"
                            role="button"><i class="fab fa-twitter"></i></a>

                        <!-- Instagram -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac" href="#!"
                            role="button"><i class="fab fa-instagram"></i></a>


                    </div>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6 col-lg-4 col-xl-4 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
                    <p><i class="fas fa-home mr-3"></i> Paragon Village Blog CLG-00L Jl.Raya Binong Kav 9 Karawaci 15810
                        Banten-Indonesia</p>
                    <p><i class="fas fa-envelope mr-3"></i> jubelse@o-rumah.com</p>
                    <p><i class="fas fa-phone mr-3"></i> 021-59493900</p>
                    <p> </p>
                </div>
                <!-- Grid column -->
            </div>
            <!--Grid row-->
        </section>
    </div>
    <!-- Footer -->
    <!-- Footer -->
    <footer class="footer">
        © 2024 O-Rumah.
    </footer>
    <!-- End Footer -->

    <!-- End Footer -->
    <!-- Remove the container if you want to extend the Footer to full width. -->

    <!-- End of .container -->


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