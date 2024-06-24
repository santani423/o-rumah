<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{$title}} O-Rumah</title>
    <meta content="{{$title}}" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo-o-rumah-crop.png')}}">

    <link href="{{asset('zenter/vertical/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('zenter/vertical/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('zenter/vertical/assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <style>
        .btn-turquoise {
            background-color: #47C8C5;
            border-color: #47C8C5;
            color: white
        }
    </style>

    {{$css}}

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

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


                        <!-- end page title end breadcrumb -->
                        {{$body}}

                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            <footer class="footer">
                © 2024 O-Rumah.
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
    <!-- 
    <script src="{{asset('zenter/vertical/assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/plugins/tabledit/jquery.tabledit.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/tabledit.init.js')}}"></script> -->

    <!-- App js -->
    <script src="{{asset('zenter/vertical/assets/js/app.js')}}"></script>

    {{$js}}

</body>

</html>