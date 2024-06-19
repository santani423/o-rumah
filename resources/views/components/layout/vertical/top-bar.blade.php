<div class="topbar ">

    <nav class="navbar-custom bg-dark">

        <ul class="list-inline float-right mb-0 ">
            <!-- language-->
            @if(Auth::user())
                <x-Layout.Horizontal.NavProvile></x-Layout.Horizontal.NavProvile>
            @else
                <x-Layout.Horizontal.NavBeforAuth></x-Layout.Horizontal.NavBeforAuth>
            @endif

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>