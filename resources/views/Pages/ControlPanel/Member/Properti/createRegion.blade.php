<x-Layout.Vertical.Master>



    @slot('css')
    <!-- Menambahkan CSS untuk Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    </style>
    @endslot

    @slot('js')


    @endslot
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Pasang Iklan</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <x-Layout.Item.PropertyRegionForm :url="route('member.properti.create.listing')">
    </x-Layout.Item.PropertyRegionForm>
    @endslot
</x-Layout.Vertical.Master>