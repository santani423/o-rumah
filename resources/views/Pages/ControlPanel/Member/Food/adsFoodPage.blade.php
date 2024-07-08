<x-Layout.Vertical.Master>

    @slot('css')
    <style>
        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            padding: 20px;
            text-align: center;
            color: #bdbdbd;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }

        .dropzone:hover {
            background: #f8f9fa;
            cursor: pointer;
        }

        .dropzone p {
            margin: 0;
            font-size: 16px;
        }

        img {
            max-width: 100px;
            height: auto;
            margin-right: 10px;
        }
    </style>
    @endslot
    @slot('js')

    <!--Wysiwig js-->
    <script src="{{asset('zenter/vertical/assets/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/editor.init.js')}}"></script>
    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.value.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            angka.value = prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const incrementButtons = document.querySelectorAll('.btn-increment');
            const decrementButtons = document.querySelectorAll('.btn-decrement');

            console.log('Increment Buttons:', incrementButtons.length);
            console.log('Decrement Buttons:', decrementButtons.length);

            incrementButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.parentElement.previousElementSibling;
                    input.value = parseInt(input.value, 10) + 1;
                    console.log('Incremented Value:', input.value);
                });
            });

            decrementButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.parentElement.previousElementSibling;
                    if (parseInt(input.value, 10) > 0) {
                        input.value = parseInt(input.value, 10) - 1;
                        console.log('Decremented Value:', input.value);
                    }
                });
            });
        });
    </script>
    <script>
        let currentFiles = []; // Array untuk menyimpan file yang telah di-upload

        document.getElementById('dropzone').addEventListener('dragover', function (event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.background = '#e1e7ed';
        });

        document.getElementById('dropzone').addEventListener('dragleave', function (event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.background = 'white';
        });

        document.getElementById('dropzone').addEventListener('drop', function (event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.background = 'white';
            const files = event.dataTransfer.files;
            for (let i = 0; i < files.length; i++) {
                if (!currentFiles.some(f => f.name === files[i].name && f.size === files[i].size)) {
                    currentFiles.push(files[i]);
                }
            }
            updatePreviewAndCount();
        });

        document.getElementById('fileInput').addEventListener('change', function () {
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                if (!currentFiles.some(f => f.name === files[i].name && f.size === files[i].size)) {
                    currentFiles.push(files[i]);
                }
            }
            updatePreviewAndCount();
        });

        function updatePreviewAndCount() {
            const previewContainer = document.getElementById('preview');
            previewContainer.innerHTML = ''; // Bersihkan preview sebelumnya

            // Tampilkan jumlah file
            document.getElementById('fileCount').textContent = currentFiles.length;

            // Membuat preview untuk setiap file
            currentFiles.forEach((file, index) => {
                const fileUrl = URL.createObjectURL(file);
                const preview = document.createElement('div');
                preview.innerHTML = `
                    <img src="${fileUrl}" style="max-width: 100px; height: auto; margin-right: 10px;">
                    <button type="button" class="btn-danger" onclick="removeFile(${index})">Remove</button>
                `;
                previewContainer.appendChild(preview);
            });
        }

        function removeFile(index) {
            // Menghapus file dari array berdasarkan index
            currentFiles.splice(index, 1);

            // Update preview dan jumlah file
            updatePreviewAndCount();
        }
    </script>
    @endslot
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <!-- <div class="btn-group float-right">
                    <a href="{{route('member.properti.create')}}" class="btn btn-turquoise">Pasang Iklan</a>
                </div> -->
                <h4 class="page-title">Tambah Food</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title font-20 mt-0">Lokasi</h4>
                    <div class="row">

                        <div class="col-lg-6">
                            <h4 class="card-title font-20 mt-0">{{$data['area']}}</h4>
                            <p>{{$data['area']}}</p>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href=" {{route('member.properti.create')}}" class="btn btn-turquoise">Ubah Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('member.food.store.listing')}}" method="post" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="district_id" value="{{$data['districtId']}}">
                <input type="hidden" name="district_name" value="{{$data['district']}}">
                <input type="hidden" name="lat" value="{{$data['lat']}}">
                <input type="hidden" name="lng" value="{{$data['lng']}}">
                <input type="hidden" name="area" value="{{$data['area']}}">
                <input type="hidden" name="adres" value="{{$data['adres']}}">


                <x-Layout.Item.PropertyAdForm>
                </x-Layout.Item.PropertyAdForm>

                <x-Layout.Item.FormKategoriFood>
                </x-Layout.Item.FormKategoriFood>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-20 mt-0">Upload Dokumen</h4>
                        @error('fileInput')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div id="dropzone" class="dropzone" onclick="document.getElementById('fileInput').click();">
                            <input type="file" id="fileInput" name="fileInput[]" accept="image/*" multiple
                                style="display: none;">
                            <p>Drag file ke sini atau klik untuk memilih file</p>
                        </div>
                        <div id="preview"></div>
                        <p>Jumlah gambar yang di-upload: <span id="fileCount">0</span></p>


                        <div class="text-right">
                            <button class="btn btn-turquoise">Simpan</button>
                        </div>
                    </div>
                </div>
        </div>


    </div>
    </div>
    </form>
    @endslot

</x-Layout.Vertical.Master>