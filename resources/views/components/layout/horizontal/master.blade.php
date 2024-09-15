<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{$title}}  O-Rumah</title>
    <meta content="{{$title}}" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph tags -->
    <meta property="og:title" content="{{$title}} - O-Rumah" />
    <meta property="og:description" content="{{$title}}" />
    <meta property="og:image" content="{{ asset($ogImage)}}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <link rel="shortcut icon" href="{{ asset($ogImage)}}">
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
        
        .logo {
            height: 100%;
        }

        .logo {
            width: 50px; /* Sesuaikan dengan lebar yang diinginkan */
            height: auto; /* Sesuaikan dengan tinggi yang diinginkan */
            overflow: hidden; /* Pastikan gambar tidak keluar dari pembungkus */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-orumah {
            height: 56px; /* Tinggi gambar mengikuti tinggi pembungkus */
            width: auto; /* Lebar gambar otomatis mengikuti tinggi gambar */
        }
    </style>
    <style>
    .bg-custom {
        background-color: #47C8C5;
        color: white; /* Warna teks putih untuk kontras yang baik */
        padding: 20px; /* Memberikan padding */
    }

    .bg-custom h6 {
        color: white; /* Warna teks header putih */
    }

    .bg-custom p, .bg-custom a {
        color: white; /* Warna teks dan link putih */
    }

    .bg-white {
        background-color: white;
        padding: 20px; /* Memberikan padding */
    }
    .menu-icon {
    width: 50px; /* Ganti dengan ukuran yang diinginkan */
    height: 50px; /* Ganti dengan ukuran yang diinginkan */
}
 
.bg-dark {
    background-color: #eff3f6 ;
}
</style>

    <link href="{{ asset('zenter/horizontal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('zenter/horizontal/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('zenter/horizontal/assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

</head>



<body class="bg-light" translate="no">

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

    <div class="bg-custom">
        <section class="container-fluid">
            <!--Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">o-Rumah</h6>
                    <p>Merupakan platform marketplace yang menyediakan pilihan fitur-fitur yang menarik dan lengkap seperti properti, food, merchant, estate management serta akan terus mengembangkan fitur-fitur lainnya untuk memenuhi kebutuhan customer dengan konsep <b> ONE STOP SHOPPING </b>yang didukung oleh perbankan, daveloper, agent property, UMKM dan lainnya.</p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3 bg-custom">
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
                <div class="col-md-6 col-lg-4 col-xl-4 mx-auto bg-custom">
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

    <script>
         function fetchUnreadMessagesCount() {
        $.ajax({
            url: '/unread-messages-count',
            method: 'GET',
            success: function(response) {
                // Update jumlah pesan yang belum dibaca pada elemen dengan id 'chat-unread-count'
                if(response.unreadCount > 0){

                    $('#chat-unread-count').text(response.unreadCount);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching unread messages count:", error);
            }
        });
    }

    // Panggil fungsi fetchUnreadMessagesCount setiap 3 detik
    setInterval(fetchUnreadMessagesCount, 3000);
    </script>
    <!-- App js -->
    <script src="{{ asset('zenter/horizontal/assets/js/app.js')}}"></script>
</body>

</html>