<!-- <li class="list-inline-item hide-phone app-search">
    <form role="search" class="">
        <input type="text" placeholder="Search..." class="form-control">
        <a href=""><i class="fa fa-search"></i></a>
    </form>
</li> -->
<!-- language-->


<li class="list-inline-item dropdown notification-list">
    <a class="nav-link dropdown-toggle arrow-none waves-effect" href="{{route('member.favorit')}}" role="button"
        aria-haspopup="false" aria-expanded="true">
        <i class="mdi mdi-heart-outline mt-2" style=" font-size: 24px;"></i>

        <span class="badge badge-danger noti-icon-badge" id="like-count">{{$like}}</span>
    </a>
    <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect" href="#" role="button" aria-haspopup="false"
        aria-expanded="true">
        <i class="mdi mdi-file-send mt-2" style=" font-size: 24px;"></i>
        <span class="badge badge-danger noti-icon-badge">5</span>
    </a> -->
</li>
--{{asset(Auth::user()->image)}}
<!-- notification-->

<!-- User-->
<li class="list-inline-item dropdown notification-list">
    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <img src="@if(Auth::user()->image){{asset(Auth::user()->image)}}@else{{ asset('zenter/horizontal/assets/images/users/avatar-1.jpg')}}@endif"
            alt="user" class="rounded-circle">
    </a>
    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
        <!-- item-->
        <div class="dropdown-item noti-title">
            <h5>{{Auth::user()->name}}</h5>
        </div>
        <a class="dropdown-item" href="{{route('member.profile')}}"><i
                class="mdi mdi-account-circle m-r-5 text-muted"></i>
            Profile</a>
        <a class="dropdown-item" href="{{route('listing.index')}}"><i class="mdi mdi-wallet m-r-5 text-muted"></i>
            Dashboard</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{route('auth.logout')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i>
            Logout</a>
    </div>
</li>