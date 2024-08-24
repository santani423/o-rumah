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
            <img class="d-flex mr-3 rounded-circle" src="@if(Auth::user()->image){{asset(Auth::user()->image)}}@else{{ asset('zenter/horizontal/assets/images/users/avatar-1.jpg')}}@endif" alt="Generic placeholder image" height="64" width="64" class="rounded-circle">
            <div class="media-body">
                <h5 class="mt-0 font-14">{{ Auth::user()->name }}</h5>
            </div>
        </div>
        <div class="media mt-4 pl-2">
            <div class="d-flex align-items-center">
                <img src="@if(Auth::user()->company_image){{ asset(Auth::user()->company_image) }}@else{{ asset('zenter/horizontal/assets/images/users/avatar-1.jpg') }}@endif" alt="Generic placeholder image" height="34" width="34" class="rounded-circle mr-3">
                @if(Auth::user()->company_image)<div class="media-body text-truncate">
                    <h5 class="mt-0 font-14 mb-0 text-truncate">{{ Auth::user()->company_name }}</h5>
                </div>@endif
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12 mt-1">
                <div class="card m-3 bg-light pr-2">
                    <h3 class="mt-0 mb-1 ml-2 font-14">Poin</h3>
                    <p class="card-text mb-2 ml-2 p-0">{{ number_format($poin->balance, 0, '.', '') }}</p>
                    <a href="https://member.o-rumah.com">
                        <button class="btn btn-turquoise " style="width: 105%;"> <i class="fas fa-sitemap"></i> Keanggotaan MLM</button></a>
                </div>
            </div>
        </div>

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Menu</li>
                @if(Auth::user()->plan_id == null || Auth::user()->plan_id == '')
                <li>
                    <a href="{{route('member.plans')}}" class="waves-effect">
                        <i class="far fa-paper-plane"></i>
                        <span> Member Plan  </span>
                    </a>
                </li>
                @else
                <x-Item.LinkTopUpComponent :planId="Auth::user()->plan_id">
                </x-Item.LinkTopUpComponent>
                @endif
                @if(Auth::user()->type == 'agen' || Auth::user()->type == 'agent' || Auth::user()->type == 'notaris' || Auth::user()->type == 'lbh')
                <li>
                    <a href="{{route('listing.index')}}" class="waves-effect">
                        <i class="mdi mdi-home"></i>
                        <span> Properti </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('member.lelang')}}" class="waves-effect">
                        <i class="mdi mdi-gavel"></i>
                        <span> Lelang </span>
                    </a>
                </li>
                @endif
               
              
                <li>
                    <a href="{{route('member.food')}}" class="waves-effect">
                        <i class="mdi mdi-food-fork-drink"></i>
                        <span> Food </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('member.merchants')}}" class="waves-effect">
                        <i class="mdi mdi-store"></i>
                        <span> Merchant </span>
                    </a>
                </li>

                @if(Auth::user()->type == 'agen' || Auth::user()->type == 'agent' || Auth::user()->type == 'notaris' || Auth::user()->type == 'lbh')
                <li>
                    <a href="{{route('member.pengajuan.kpr')}}" class="waves-effect">
                        <i class="mdi mdi-bank"></i>
                        <span> Pengajuan KPR </span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{route('member.transaksi')}}" class="waves-effect">
                        <i class="mdi mdi-credit-card"></i>
                        <span> Riwayat Transaksi </span>
                    </a>
                </li>
            
                @if(Auth::user()->type == 'administrator')
                <li>
                    <a href="{{route('admin.nav.lelang')}}" class="waves-effect">
                        <i class="mdi mdi-gavel"></i>
                        <span> Lelang </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.pengajuan.kpr')}}" class="waves-effect">
                        <i class="mdi mdi-bank"></i>
                        <span> Pengajuan KPR </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.pengajuan.lelang')}}" class="waves-effect">
                        <i class="mdi mdi-gavel"></i>
                        <span> Pengajuan Lelang </span>
                    </a>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-database"></i><span> Master
                        </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.bank')}}">Bank</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-folder"></i><span> Browser
                        </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.banner')}}">Banner</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-group"></i><span> Pengguna
                        </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.pengguna','agent')}}">Agent</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.pengguna','food')}}">Food</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.pengguna','merchant')}}">Marchant</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.pengguna','lbh')}}">LBH</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.pengguna','notaris')}}">Notaris</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-settings"></i><span> Setting
                        </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.ads.control-panel')}}">Plan Controll</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.ads.control-booster')}}">Booster</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.nav.kategoriAds')}}">Kategori Ads</a></li>
                    </ul>
                </li>
                @endif

                <li>
                    <a href="{{route('member.profile')}}" class="waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span> Profile </span>
                    </a>
                </li>
                @if(Auth::user()->type != 'food' && Auth::user()->type != 'merchant' )
                <li>
                    <a href="{{route('listing.control-panel.wilayah-kerja')}}" class="waves-effect">
                        <i class="mdi mdi-map-marker"></i>
                        <span> Wilayah Kerja </span>
                    </a>
                </li>
                @endif
                @if(config('app.setDevCheting') === true)
                <li>
                    <a href="{{route('member.chat')}}" class="waves-effect">
                        <i class="mdi mdi-map-marker"></i>
                        <span> Chat </span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}" class="waves-effect">
                        <i class="mdi mdi-logout"></i>
                        <span> Logout </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
