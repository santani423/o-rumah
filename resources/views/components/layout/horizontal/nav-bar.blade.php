<header id="topnav">
    <div class="topbar-main ">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="index.html" class="logo">-->
                <!--Zoter-->
                <!--</a>-->
                <!-- Image Logo -->
                <a href="/" class="logo">
                    <img src="{{ asset('assets/logo.png')}}" alt="" class="logo-large"
                        style="width: 90px; height: auto;">
                </a>

            </div>
            <!-- End Logo container-->


            <div class="menu-extras topbar-custom">

                <ul class="list-inline float-right mb-0 ">
                    @if(Auth::user())
                        <x-Layout.Horizontal.NavProvile></x-Layout.Horizontal.NavProvile>
                    @else
                        <x-Layout.Horizontal.NavBeforAuth></x-Layout.Horizontal.NavBeforAuth>
                    @endif
                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>

            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <!-- MENU Start -->
    <div class="navbar-custom " style="background-color: #47C8C5;
    border-color: #47C8C5; ">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu text-center">

                    <li class="has-submenu ">
                        <a href="{{route('latest')}}"> Properti Baru</a>
                    </li>
                    <li class="has-submenu ">
                        <a href="{{route('auction')}}"> Properti Lelang</a>
                    </li>
                    @if(Auth::user())
                        <li class="has-submenu">
                            <a href="#"> Pengajuan</a>
                            <ul class="submenu">

                                <li>
                                    <a href="{{route('member.pengajuan.kpr')}}">Kpr</a>
                                </li>
                                <li>
                                    <a href="{{route('member.pengajuan.lelang')}}">Lelang</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="has-submenu ">
                        <a href="{{route('aboutAs')}}"> About Us</a>
                    </li>
                    <!-- <li class="has-submenu">
                        <a href="#"> Components</a>
                        <ul class="submenu">
                            <li class="has-submenu">
                                <a href="#">Forms</a>
                                <ul class="submenu">
                                    <li><a href="form-elements.html">Form Elements</a></li>
                                    <li><a href="form-validation.html">Form Validation</a></li>
                                    <li><a href="form-advanced.html">Form Advanced</a></li>
                                    <li><a href="form-editors.html">Form Editors</a></li>
                                    <li><a href="form-uploads.html">Form File Upload</a></li>
                                    <li><a href="form-mask.html">Form Mask</a></li>
                                    <li><a href="form-summernote.html">Summernote</a></li>
                                    <li><a href="form-xeditable.html">Form Xeditable</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="calendar.html">Calendar</a>
                            </li>
                        </ul>
                    </li> -->

                    <!-- <li class="has-submenu">
                        <a href="#"> Pages</a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="pages-login.html">Login</a></li>
                                    <li><a href="pages-register.html">Register</a></li>
                                    <li><a href="pages-recoverpw.html">Recover Password</a></li>
                                    <li><a href="pages-lock-screen.html">Lock Screen</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li><a href="pages-blank.html">Blank Page</a></li>
                                    <li><a href="pages-404.html">Error 404</a></li>
                                    <li><a href="pages-500.html">Error 500</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->

                </ul>


                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<x-Layout.Item.Modal.Login></x-Layout.Item.Modal.Login>
<x-Layout.Item.Modal.Registrasi></x-Layout.Item.Modal.Registrasi>