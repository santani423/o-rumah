<x-Layout.Vertical.Master>
    @slot('css')
        <link href="{{ asset('zenter/horizontal/assets/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('zenter/horizontal/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>

        <style>
            .square {
                position: relative;
                width: 100%;
                padding-bottom: 100%; /* Membuat pembungkus berbentuk bujur sangkar */
            }
            .square-img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover; /* Menyesuaikan gambar agar tetap proporsional */
            }
            .preview-container {
                display: flex;
                flex-wrap: wrap;
            }
            .preview-image {
                position: relative;
                margin: 10px;
            }
            .preview-image img {
                max-width: 150px;
                max-height: 150px;
                object-fit: cover;
                margin-bottom: 5px;
            }
            .remove-image {
                position: absolute;
                top: 0;
                right: 0;
                background: rgba(255, 0, 0, 0.7);
                color: white;
                border: none;
                cursor: pointer;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #loading-spinner {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1050; /* Ensure it appears above other elements */
                display: none;
            }
        </style>
    @endslot

    @slot('js')
        <!-- Magnific popup -->
        <script src="{{ asset('zenter/horizontal/assets/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('zenter/horizontal/assets/pages/lightbox.js') }}"></script>
        <!-- Dropzone js -->
        <script src="{{ asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.js') }}"></script>
        <script src="{{ asset('zenter/horizontal/assets/plugins/dropify/js/dropify.min.js') }}"></script>
        <script src="{{ asset('zenter/horizontal/assets/pages/upload.init.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle Image Modal
                $('#imageModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var url = button.data('url');
                    var mediaId = button.data('media-id');
                    var modal = $(this);
                    modal.find('#modalImage').attr('src', url);
                    modal.find('#mediaForm').attr('action', '/listing/media/' + mediaId + '/update');
                });

                // Handle Confirm Modal
                var form;
                $('#confirmModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var url = button.data('url');
                    form = button.closest('form');
                    var modal = $(this);
                });

                $('#confirmButton').on('click', function () {
                    if (form) {
                        form.submit();
                    }
                });

                // Handle Delete Confirmation Modal
                var deleteForm;
                $('#deleteConfirmModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    deleteForm = button.closest('form');
                });

                $('#deleteButton').on('click', function () {
                    if (deleteForm) {
                        deleteForm.submit();
                    }
                });

                // Initialize Dropify
                $('.dropify').dropify();

                // Image upload and preview
                const imageInput = document.getElementById('multiple-image-input');
                const previewContainer = document.getElementById('preview-container');
                const imagesData = [];

                imageInput.addEventListener('change', function () {
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = new Image();
                            img.src = e.target.result;
                            img.onload = function () {
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                const maxWidth = 800;
                                const maxHeight = 800;
                                let width = img.width;
                                let height = img.height;

                                if (width > height) {
                                    if (width > maxWidth) {
                                        height *= maxWidth / width;
                                        width = maxWidth;
                                    }
                                } else {
                                    if (height > maxHeight) {
                                        width *= maxHeight / height;
                                        height = maxHeight;
                                    }
                                }
                                canvas.width = width;
                                canvas.height = height;
                                ctx.drawImage(img, 0, 0, width, height);
                                const dataUrl = canvas.toDataURL('image/jpeg');
                                
                                imagesData.push(dataUrl);
                                const previewDiv = document.createElement('div');
                                previewDiv.classList.add('preview-image');
                                previewDiv.innerHTML = `<img src="${dataUrl}" alt="Image Preview"><button class="remove-image">&times;</button>`;
                                previewContainer.appendChild(previewDiv);

                                previewDiv.querySelector('.remove-image').addEventListener('click', function () {
                                    const index = imagesData.indexOf(dataUrl);
                                    if (index > -1) {
                                        imagesData.splice(index, 1);
                                        previewDiv.remove();
                                    }
                                });
                            };
                        };
                        reader.readAsDataURL(file);
                    });
                });

                // Handle AJAX upload
                document.getElementById('upload-images-button').addEventListener('click', function () {
                    // Show spinner
                    document.getElementById('loading-spinner').style.display = 'block';

                    $.ajax({
                        url: "{{ route('listing.control-panel.food.upload.images', $ads['ads_id']) }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            images: imagesData
                        },
                        success: function (response) {
                            // Hide spinner
                            document.getElementById('loading-spinner').style.display = 'none';

                            if (response.success) {
                                location.reload(); // Reload the page to show success message
                            }
                        },
                        error: function (xhr) {
                            // Hide spinner
                            document.getElementById('loading-spinner').style.display = 'none';

                            alert('An error occurred while uploading images.');
                            console.log(xhr.responseText);
                        }
                    });
                });
            });

            function setFormMediaId(id){
                $('#mediaIdValue').val(id);
            }
        </script>
    @endslot

    @slot('body')
        <div id="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(!$navLink) active @endif" data-toggle="tab" href="#food" role="tab">Tentang Food</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($navLink == 'galeri') active @endif" data-toggle="tab" href="#galeri" role="tab">Galeri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($navLink == 'lokasi') active @endif" data-toggle="tab" href="#lokasi" role="tab">Lokasi</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane @if(!$navLink) active @endif p-3" id="food" role="tabpanel">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 200px">Judul Iklan</th>
                                            <td>{{ $ads['title'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 200px">Harga</th>
                                            <td>{{ number_format($ads['price'], 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 200px">Deskripsi</th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                {!! $ads['description'] !!}
                                <br>
                                <br>
                                <a href="{{ route('listing.control-panel.food.edit.tentang-food', $ads['slug']) }}">
                                    <button class="btn btn-turquoise">Edit</button>
                                </a>
                            </div>
                            
                            <div class="tab-pane @if($navLink == 'galeri') active @endif p-3" id="galeri" role="tabpanel">
                                <div class="mb-3">
                                    <input type="file" id="multiple-image-input" multiple>
                                </div>
                                <div class="preview-container" id="preview-container"></div>
                                <button class="btn btn-turquoise mt-3" id="upload-images-button">Upload Images</button>

                                <div class="container zoom-gallery mt-4">
                                    <div class="row">
                                        @foreach($media as $key => $md)
                                            <div class="col-md-4 mb-4">
                                                <div class="square">
                                                    <a href="{{ asset($md['url']) }}" title="Media {{ ++$key }}" data-url="{{ asset($md['url']) }}">
                                                        <img src="{{ asset($md['url']) }}" alt="" class="img-fluid square-img" />
                                                    </a>
                                                </div>
                                                @if($ads['image'] != $md['url'])
                                                    <form action="{{ route('listing.control-panel.food.set.media.utama', $ads['omerchants_id']) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="url" value="{{ $md['url'] }}">
                                                        <button type="button" class="btn btn-turquoise mt-2" data-toggle="modal" data-target="#confirmModal" data-url="{{ $md['url'] }}">Jadikan Utama</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-success mt-2">Utama</button>
                                                @endif
                                                <button type="button" class="btn btn-turquoise mt-2" data-toggle="modal" data-target="#imageModal" onclick="setFormMediaId(`{{ $md['id'] }}`)" data-url="{{ $md['url'] }}" data-media-id="{{ $md['id'] }}">Edit</button>

                                                <!-- Delete media button -->
                                                <form action="{{ route('listing.media.delete', $md['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#deleteConfirmModal">Hapus</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Image Modal -->
                                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Ubah Media</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form id="mediaForm" action="" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="mediaId" id="mediaIdValue">
                                                    <div class="col-xl-12">
                                                        <input type="file" id="input-file-now" class="dropify" name="media" required />
                                                    </div>
                                                    <button type="submit" class="btn btn-turquoise mt-3">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Confirm Modal -->
                                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menjadikan gambar ini sebagai media utama?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-turquoise" id="confirmButton">Jadikan Utama</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus media ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-danger" id="deleteButton">Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane p-3 @if($navLink == 'lokasi') active @endif" id="lokasi" role="tabpanel">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 200px">Provinsi</th>
                                            <td>{{ $ads['name_provinces'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 200px">Kabupaten/Kota</th>
                                            <td>{{ $ads['name_cities'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 200px">Kecamatan</th>
                                            <td>{{ $ads['district'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 200px">Area</th>
                                            <td>{{ $ads['kawasan'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="width: 200px">Alamat</th>
                                            <td>{{ $ads['alamat'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('listing.control-panel.food.edit.addres', $ads['slug']) }}">
                                    <button class="btn btn-turquoise">Edit</button>
                                </a>
                            </div>

                            <div class="tab-pane p-3 @if($navLink == 'booster') active @endif" id="booster" role="tabpanel">
                                <button type="button" class="btn btn-turquoise waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-sm">Booster</button>
                                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="boosterModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0" id="boosterModal">Booster</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <div class="form-group row">
                                                        @csrf
                                                        <input type="hidden" name="ads_id" value="{{ $ads->ads_id }}">
                                                        <label class="col-sm-2 col-form-label">Posisi Booster</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="booster_id" required>
                                                                <option value="">Pilih Posisi</option>
                                                                @foreach($bosterAdsType as $bat)
                                                                    <option value="{{ $bat->id }}">{{ $bat->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-turquoise">Pasang</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Booster</th>
                                            <th>Di Terapkan Pada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($BosterAds as $key => $ba)
                                            <tr>
                                                <th scope="row">{{ ++$key }}</th>
                                                <td>{{ $ba->title }}</td>
                                                <td>{{ $ba->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane p-3 @if($navLink == 'depositAds') active @endif" id="depositAds" role="tabpanel">
                                <x-Member.Item.TitipAds :ads="$ads"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endslot
</x-Layout.Vertical.Master>
