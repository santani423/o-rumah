<x-Layout.Vertical.Master title="Dashboard">
    @slot('body')
   

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <!-- <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="#">Zoter</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div> -->
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- end page title end breadcrumb -->
             <x-Item.Dashboard.FoodAndMarchent />
           


          

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->
    @endslot
</x-Layout.Vertical.Master>