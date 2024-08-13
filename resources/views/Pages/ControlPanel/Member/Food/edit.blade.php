<x-Layout.Vertical.Master title="Edit Food">

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
    <!-- Summernote css -->
    <link href="{{asset('zenter/vertical/assets/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet" />
    @endslot
    @slot('js')

    <!--Wysiwig js-->
    <script src="{{asset('zenter/vertical/assets/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/editor.init.js')}}"></script>
     <!--Summernote js-->
     <script src="{{asset('zenter/vertical/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/summernote.init.js')}}"></script>
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
                <h4 class="page-title">Edit Food</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        
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
            <form action="{{ route('listing.control-panel.food.update', $ads['ads_id']) }}" method="post" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                


                <x-Layout.Item.Food.Edit.PropertyAdForm :ads="$ads">
                </x-Layout.Item.Food.Edit.PropertyAdForm>

                <!-- <x-Layout.Item.FormKategoriFood>
                </x-Layout.Item.FormKategoriFood> -->

               
        </div>


    </div>
    </div>
    </form>
    @endslot

</x-Layout.Vertical.Master>