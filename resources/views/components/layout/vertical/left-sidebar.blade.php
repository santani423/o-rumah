<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <!-- LOGO -->
    <div class="topbar-left bg-dark">
        <div class="text-center">
            <a href="/" class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="" class="logo-orumah img-fluid">
            </a>
        </div>
    </div>
    <div class="sidebar-inner niceScrollleft">
        <div class="media mt-4 pl-2">
            <img class="d-flex mr-3 rounded-circle"
                src="{{ asset('zenter/vertical/assets/images/users/avatar-6.jpg') }}" alt="Generic placeholder image"
                height="64">
            <div class="media-body">
                <h5 class="mt-0 font-14">{{ Auth::user()->name }}</h5>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12 mt-1">
                <div class="card m-3 bg-light pr-2">
                    <!-- <h3 class="mt-0 mb-1 font-14">Anggota Sejak</h3>
               
                    <hr> -->
                    <h3 class="mt-0 mb-1 ml-2 font-14">Poin</h3>

                    <p class="card-text mb-2 ml-2 p-0">{{ number_format($poin->balance, 0, '.', '') }}</p>
                    <button class="btn btn-success">Keanggotaan MLM</button>
                </div>
            </div>
        </div>

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Menu</li>
                @if(Auth::user()->type != 'administrator')
                    <li>
                        <a href="{{route('listing.index')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    
                        @if(Auth::user()->type == 'agen' || Auth::user()->type == 'agent' || Auth::user()->type == 'notaris' || Auth::user()->type == 'lbh')
                    <li>
                        <a href="{{route('member.lelang')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Lelang </span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{route('member.plans')}}" class="waves-effect">
                            <i class="far fa-paper-plane"></i>
                            <span> Member Plan </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('member.food')}}" class="waves-effect">
                            <i class="mdi mdi-food-fork-drink"></i>
                            <span> Food </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('member.merchants')}}" class="waves-effect">
                            <i class="mdi mdi-basket"></i>
                            <span> Merchant </span>
                        </a>
                    </li>
                    
                        @if(Auth::user()->type == 'agen' || Auth::user()->type == 'agent' || Auth::user()->type == 'notaris' || Auth::user()->type == 'lbh')
                    <li>
                        <a href="{{route('member.pengajuan.kpr')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Pengajuan KPR </span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{route('member.transaksi')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Riwayat Transaksi </span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->type == 'administrator')
                    <li>
                        <a href="{{route('admin.nav.lelang')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Lelang </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.pengajuan.kpr')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Pengajuan KPR </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.pengajuan.lelang')}}" class="waves-effect">
                            <i class="mdi mdi-airplay"></i>
                            <span> Pengajuan Lelang </span>
                        </a>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-table"></i><span> Master
                            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('admin.nav.bank')}}">Bank</a></li> 
                        </ul>
                        <ul class="list-unstyled"> 
                            <li><a href="{{route('admin.nav.typeProperti')}}">Type Properti</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-table"></i><span> Browser
                            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('admin.nav.banner')}}">Banner</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-table"></i><span> Setting
                            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('admin.nav.ads.control-panel')}}">Plan Controll</a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="{{route('admin.nav.ads.control-booster')}}">Booster</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>