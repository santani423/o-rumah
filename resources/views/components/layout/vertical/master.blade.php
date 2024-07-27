<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{$title}}</title>
        <meta content="{{$title}}" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">    <link rel="shortcut icon" href="{{ asset('assets/logo-o-rumah-crop.png')}}">

        <!-- DataTables -->
        <link href="{{asset('zenter/vertical/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('zenter/vertical/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{asset('zenter/vertical/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" /> 

        <link href="{{asset('zenter/vertical/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('zenter/vertical/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('zenter/vertical/assets/css/style.css')}}" rel="stylesheet" type="text/css">
        <style>
        .btn-turquoise {
            background-color: #47C8C5;
            border-color: #47C8C5;
            color: white
        }
        .logo-orumah {
            height: 80px; /* Tinggi gambar mengikuti tinggi pembungkus */
            width: auto; /* Lebar gambar otomatis mengikuti tinggi gambar */
        }
    </style>

    {{$css}}


    </head>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

          <!-- ========== Left Sidebar Start ========== -->
        <x-Layout.Vertical.LeftSidebar></x-Layout.Vertical.LeftSidebar>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <x-Layout.Vertical.TopBar></x-Layout.Vertical.TopBar>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                        {{$body}}
            
                            

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    © 2019 Zoter by Mannatthemes.
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="{{asset('zenter/vertical/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/popper.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/detect.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/fastclick.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/waves.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/js/jquery.nicescroll.js')}}"></script>

        <!-- Required datatable js -->
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/pdfmake.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('zenter/vertical/assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
 
        <!-- Datatable init js -->
        <script src="{{asset('zenter/vertical/assets/pages/datatables.init.js')}}"></script> 
        {{$js}}
        <!-- App js -->
        <script src="{{asset('zenter/vertical/assets/js/app.js')}}"></script>
        <script>
            $(document).ready(function() {
                $('#datatable2').DataTable();  
            } );
        </script>

    </body>
</html>