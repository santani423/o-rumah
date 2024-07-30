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

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <style>
        .preview-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 10px;
        }

        .preview-container {
            display: flex;
            flex-wrap: wrap;
        }

        .preview-container .img-preview-container {
            position: relative;
            display: inline-block;
        }

        .preview-container .img-preview-container button {
            position: absolute;
            top: 5px;
            right: 5px;
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
        document.addEventListener('DOMContentLoaded', function() {
            const incrementButtons = document.querySelectorAll('.btn-increment');
            const decrementButtons = document.querySelectorAll('.btn-decrement');

            incrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.previousElementSibling;
                    input.value = parseInt(input.value, 10) + 1;
                });
            });

            decrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.previousElementSibling;
                    if (parseInt(input.value, 10) > 0) {
                        input.value = parseInt(input.value, 10) - 1;
                    }
                });
            });
        });
    </script>
    <script>
        let currentFiles = []; // Array untuk menyimpan file yang telah di-upload

        document.getElementById('dropzone').addEventListener('dragover', function(event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.background = '#e1e7ed';
        });

        document.getElementById('dropzone').addEventListener('dragleave', function(event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.background = 'white';
        });

        document.getElementById('dropzone').addEventListener('drop', function(event) {
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

        document.getElementById('fileInput').addEventListener('change', function() {
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
    <script>
        document.getElementById('judulIklan').addEventListener('input', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#cektitle').html('');
            $.ajax({
                url: "{{ route('tool.cekJudul') }}",
                type: 'POST',
                data: {
                    judulIklan: this.value
                },
                success: function(response) {
                    if (!response.available) {
                        $('#cektitle').html(' <div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function() {
                    $('#results').html('Error: Tidak dapat mengambil data');
                }
            });
        });

        // Log the initial value on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('ddddd', document.getElementById('judulIklan').value);
        });
    </script>
    <script>
        function updateCharCount() {
            var textarea = document.getElementById('elm1');
            var charCount = document.getElementById('charCount');
            charCount.textContent = textarea.value.length + ' karakter';
        }

        document.addEventListener('DOMContentLoaded', function() {
            var textarea = document.getElementById('elm1');
            var charCount = document.getElementById('charCount');
            charCount.textContent = textarea.value.length + ' karakter';
        });
    </script>

    <script>
        const radios = document.querySelectorAll('input[name="property_type"]');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const formLuasBangunan = document.getElementById('formLuasBangunan');
                    const formTahunDibangun = document.getElementById('formTahunDibangun');
                    const formDayaListrik = document.getElementById('formDayaListrik');
                    const kamarTidurGroup = document.getElementById('kamarTidurGroup');
                    const formKondisiPrabotan = document.getElementById('formKondisiPrabotan');
                    const formfasilitas = document.getElementById('formfasilitas');
                    let sts;
                    if (this.value === 'Tanah') {
                        sts = 'none';
                    } else {
                        sts = 'block';
                    }
                    formLuasBangunan.style.display = sts;
                    formTahunDibangun.style.display = sts;
                    formDayaListrik.style.display = sts;
                    kamarTidurGroup.style.display = sts;
                    formKondisiPrabotan.style.display = sts;
                    formfasilitas.style.display = sts;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="property_type"]:checked');
            if (checkedRadio) {
                console.log(checkedRadio.value);
            }
        });
    </script>
    <script>
        const adsId = 688;
        function validateForm() {
            let valid = true;

            const adsType = document.querySelector('input[name="ads_type"]:checked');
            const propertyType = document.querySelector('input[name="property_type"]:checked');

            const title = document.getElementById('judulIklan').value.trim();
            const description = document.getElementById('descriptionIklan').value.trim();
            const price = document.getElementById('harga').value.trim();

            const housingName = document.getElementById('housing_name').value.trim();
            const clusterName = document.getElementById('cluster_name').value.trim();
            const lt = document.getElementById('lt').value.trim();
            const lb = document.getElementById('lb').value.trim();
            const yearBuilt = document.getElementById('year_built').value.trim();
            const dl = document.getElementById('dl').value.trim();
            const certificates = document.querySelectorAll('input[name="certificate[]"]:checked');
            const jk = document.getElementById('jk').value.trim();
            const jkm = document.getElementById('jkm').value.trim();
            const jl = document.getElementById('jl').value.trim();
            const houseFacilities = document.querySelectorAll('input[name="house_facility[]"]:checked');
            const furnitureCondition = document.querySelector('input[name="furniture_condition"]:checked');
            const otherFacilities = document.querySelectorAll('input[name="other_facility[]"]:checked');

            document.getElementById('adsTypeError').innerText = "";
            document.getElementById('propertyTypeError').innerText = "";
            document.getElementById('cektitle').innerText = "";
            document.getElementById('cekDescription').innerText = "";
            document.getElementById('cekPrice').innerText = "";
            document.getElementById('cekHousingName').innerText = "";
            document.getElementById('cekClusterName').innerText = "";
            document.getElementById('cekLt').innerText = "";
            document.getElementById('cekLb').innerText = "";
            document.getElementById('cekYearBuilt').innerText = "";
            document.getElementById('cekDl').innerText = "";
            document.getElementById('cekCertificate').innerText = "";
            document.getElementById('cekJk').innerText = "";
            document.getElementById('cekJkm').innerText = "";
            document.getElementById('cekJl').innerText = "";
            document.getElementById('cekHouseFacility').innerText = "";
            document.getElementById('cekFurnitureCondition').innerText = "";
            document.getElementById('cekOtherFacility').innerText = "";

            if (!adsType) {
                document.getElementById('adsTypeError').innerText = "Tipe Iklan harus diisi.";
                valid = false;
            }

            if (!propertyType) {
                document.getElementById('propertyTypeError').innerText = "Tipe Properti harus diisi.";
                valid = false;
            }

            if (!title) {
                document.getElementById('cektitle').innerText = "Judul harus diisi.";
                valid = false;
            } else if (title.length > 255) {
                document.getElementById('cektitle').innerText = "Judul tidak boleh lebih dari 255 karakter.";
                valid = false;
            }

            if (!description) {
                document.getElementById('cekDescription').innerText = "Deskripsi harus diisi.";
                valid = false;
            }

            if (!price) {
                document.getElementById('cekPrice').innerText = "Harga harus diisi.";
                valid = false;
            }

            if (housingName.length > 255) {
                document.getElementById('cekHousingName').innerText = "Nama Komplek tidak boleh lebih dari 255 karakter.";
                valid = false;
            }

            if (clusterName.length > 255) {
                document.getElementById('cekClusterName').innerText = "Nama Cluster tidak boleh lebih dari 255 karakter.";
                valid = false;
            }

            if (lt && isNaN(lt)) {
                document.getElementById('cekLt').innerText = "Luas Tanah harus berupa angka.";
                valid = false;
            }

            if (lb && isNaN(lb)) {
                document.getElementById('cekLb').innerText = "Luas Bangunan harus berupa angka.";
                valid = false;
            }

            const currentYear = new Date().getFullYear();
            if (yearBuilt && (isNaN(yearBuilt) || yearBuilt > currentYear)) {
                document.getElementById('cekYearBuilt').innerText = "Tahun Dibangun harus berupa tahun yang valid dan tidak lebih dari tahun saat ini.";
                valid = false;
            }

            if (dl && isNaN(dl)) {
                document.getElementById('cekDl').innerText = "Daya Listrik harus berupa angka.";
                valid = false;
            }

            if (certificates.length === 0) {
                document.getElementById('cekCertificate').innerText = "Tipe Sertifikat harus dipilih.";
                valid = false;
            }

            if (jk && isNaN(jk)) {
                document.getElementById('cekJk').innerText = "Jumlah Kamar Tidur harus berupa angka.";
                valid = false;
            }

            if (jkm && isNaN(jkm)) {
                document.getElementById('cekJkm').innerText = "Jumlah Kamar Mandi harus berupa angka.";
                valid = false;
            }

            if (jl && isNaN(jl)) {
                document.getElementById('cekJl').innerText = "Jumlah Lantai harus berupa angka.";
                valid = false;
            }

            if (houseFacilities.length === 0) {
                document.getElementById('cekHouseFacility').innerText = "Fasilitas harus dipilih.";
                valid = false;
            }

            if (!furnitureCondition) {
                document.getElementById('cekFurnitureCondition').innerText = "Kondisi Perabotan harus dipilih.";
                valid = false;
            }

            if (otherFacilities.length === 0) {
                document.getElementById('cekOtherFacility').innerText = "Fasilitas Perumahan harus dipilih.";
                valid = false;
            }

            if (valid) {
                showLoading();
                submitForm();
            } else {
                alert("Please fill in all required fields.");
            }
        }

        function submitForm() {
            const formData = new FormData();
            formData.append('district_id', document.getElementById('district_id').value.trim());
            formData.append('district_name', document.getElementById('district_name').value.trim());
            formData.append('lat', document.getElementById('lat').value.trim());
            formData.append('lng', document.getElementById('lng').value.trim());
            formData.append('area', document.getElementById('area').value.trim());
            formData.append('adres', document.getElementById('adres').value.trim());
            formData.append('ads_type', document.querySelector('input[name="ads_type"]:checked').value);
            formData.append('property_type', document.querySelector('input[name="property_type"]:checked').value);
            formData.append('title', document.getElementById('judulIklan').value.trim());
            formData.append('description', document.getElementById('descriptionIklan').value.trim());
            formData.append('price', document.getElementById('harga').value.trim());
            formData.append('housing_name', document.getElementById('housing_name').value.trim());
            formData.append('cluster_name', document.getElementById('cluster_name').value.trim());
            formData.append('lt', document.getElementById('lt').value.trim());
            formData.append('lb', document.getElementById('lb').value.trim());
            formData.append('year_built', document.getElementById('year_built').value.trim());
            formData.append('dl', document.getElementById('dl').value.trim());

            const certificates = Array.from(document.querySelectorAll('input[name="certificate[]"]:checked')).map(el => el.value);
            certificates.forEach((certificate, index) => {
                formData.append(`certificates[${index}]`, certificate);
            });

            formData.append('jk', document.getElementById('jk').value.trim());
            formData.append('jkm', document.getElementById('jkm').value.trim());
            formData.append('jl', document.getElementById('jl').value.trim());
            formData.append('youtubeLink', document.getElementById('youtubeLink').value.trim());

            const houseFacilities = Array.from(document.querySelectorAll('input[name="house_facility[]"]:checked')).map(el => el.value);
            houseFacilities.forEach((facility, index) => {
                formData.append(`house_facilities[${index}]`, facility);
            });

            formData.append('furniture_condition', document.querySelector('input[name="furniture_condition"]:checked').value);

            const otherFacilities = Array.from(document.querySelectorAll('input[name="other_facility[]"]:checked')).map(el => el.value);
            otherFacilities.forEach((facility, index) => {
                formData.append(`other_facilities[${index}]`, facility);
            });

            currentFiles.forEach((file, index) => {
                formData.append(`fileInput[${index}]`, file);
            });

            $.ajax({
                url: "{{route('member.properti.store.listing')}}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('response', response.data.ads_id);
                    hideLoading();
                    alert('Data berhasil disimpan!');
                     
                    console.log('adsId upload kon',response.data.id);
                 
                    uploadImageItem(); // Call image upload function here
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    alert('Terjadi kesalahan saat menyimpan data: ' + error);
                }
            });
        }

        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
    </script>
    <script>
        function changeValueMinPls(elementId, increment) {
            const input = document.getElementById(elementId);
            let currentValue = parseInt(input.value) || 0;
            currentValue += increment;
            if (currentValue < 0) {
                currentValue = 0;
            }
            input.value = currentValue;
        }
    </script>
    <script>
        $(document).ready(function() {
            var resizedPhotos = [];
            var resizedPhotosInput = document.getElementById('resized_photos');
            resizedPhotosInput.value = JSON.stringify(resizedPhotos);

            document.getElementById('photo').addEventListener('change', function(event) {
                var files = event.target.files;
                var previewContainer = document.getElementById('preview-container');

                Array.from(files).forEach(file => {
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = new Image();
                            img.onload = function() {
                                var canvas = document.createElement('canvas');
                                var ctx = canvas.getContext('2d');
                                var maxWidth = 800;
                                var maxHeight = 800;
                                var width = img.width;
                                var height = img.height;

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

                                var resizedDataUrl = canvas.toDataURL('image/jpeg');
                                resizedPhotos.push(resizedDataUrl);

                                var imgPreview = document.createElement('img');
                                imgPreview.src = resizedDataUrl;
                                imgPreview.className = 'preview-img';

                                var removeButton = document.createElement('button');
                                removeButton.type = 'button';
                                removeButton.className = 'btn btn-danger btn-sm';
                                removeButton.innerText = 'Remove';
                                removeButton.onclick = function() {
                                    var index = resizedPhotos.indexOf(resizedDataUrl);
                                    if (index !== -1) {
                                        resizedPhotos.splice(index, 1);
                                        previewContainer.removeChild(imgPreviewContainer);
                                        resizedPhotosInput.value = JSON.stringify(resizedPhotos);
                                    }
                                };

                                var imgPreviewContainer = document.createElement('div');
                                imgPreviewContainer.className = 'img-preview-container';
                                imgPreviewContainer.appendChild(imgPreview);
                                imgPreviewContainer.appendChild(removeButton);
                                previewContainer.appendChild(imgPreviewContainer);

                                resizedPhotosInput.value = JSON.stringify(resizedPhotos);
                            };
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            $('#uploadFormItem').on('submit', function(event) {
                event.preventDefault();
                var uploadStatus = document.getElementById('upload-status');
                var uploadCount = 0;

                if (resizedPhotos.length === 0) {
                    alert('Tunggu sampai gambar selesai diubah ukurannya.');
                    return;
                }

                uploadStatus.innerHTML = 'Mengupload...';

                function uploadImage(index) {
                    if (index >= resizedPhotos.length) {
                        uploadStatus.innerHTML = `Semua gambar telah berhasil diupload. Jumlah total: ${uploadCount}`;
                        return;
                    }
                    console.log('adsId upload',adsId);
                    $.ajax({
                        url: '{{ route("member.properti.store.listing.upload") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            resized_photos: [resizedPhotos[index]],
                            ads_id: adsId
                            // ads_id: document.getElementById('ads_id').value.trim()
                        },
                        success: function(response) {
                            uploadCount++;
                            uploadStatus.innerHTML = `Upload berhasil: ${uploadCount} gambar`;
                            uploadImage(index + 1);
                        },
                        error: function(xhr, status, error) {
                            uploadStatus.innerHTML = 'Terjadi kesalahan saat mengupload gambar.';
                        }
                    });
                }

                uploadImage(0);
            });
        });

        function uploadImageItem() {
            $('#uploadFormItem').submit();
        }
    </script>
    @endslot

    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Buat Iklan</h4>
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
            <form id="propertiForm" action="{{route('member.properti.store.listing')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="district_id" name="district_id" value="{{$data['districtId']}}">
                <input type="hidden" id="district_name" name="district_name" value="{{$data['district']}}">
                <input type="hidden" id="lat" name="lat" value="{{$data['lat']}}">
                <input type="hidden" id="lng" name="lng" value="{{$data['lng']}}">
                <input type="hidden" id="area" name="area" value="{{$data['area']}}">
                <input type="hidden" id="adres" name="adres" value="{{$data['adres']}}">
                <x-Layout.Item.PropertyCategoryComponent>
                </x-Layout.Item.PropertyCategoryComponent>

                <x-Layout.Item.PropertyAdForm>
                </x-Layout.Item.PropertyAdForm>

                <x-Layout.Item.PropertyDetailsForm>
                </x-Layout.Item.PropertyDetailsForm>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-20 mt-0">Lingkungan</h4>
                        <div class="form-group">
                            <label for="other_facility">Fasilitas Perumahan</label>
                            <div class="input-group">
                                @forelse ($getAllEnvironmentalConditions as $key => $condition)
                                <div class="checkbox my-2 col-lg-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="other_facility{{$key}}" name="other_facility[]" value="{{$condition}}" data-parsley-multiple="groups" data-parsley-mincheck="2" @if(in_array($condition, old('other_facility', []))) checked @endif>
                                        <label class="custom-control-label" for="other_facility{{$key}}">{{$condition}}</label>
                                    </div>
                                </div>
                                @empty
                                <p>Tidak ada kondisi lingkungan yang tersedia.</p>
                                @endforelse
                            </div>
                            <div id="cekOtherFacility" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-20 mt-0">Upload Media</h4>
                        @error('fileInput')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div id="dropzone" class="dropzone" onclick="document.getElementById('fileInput').click();">
                            <input type="file" id="fileInput" name="fileInput[]" accept="image/*" multiple style="display: none;">
                            <p>Drag file ke sini atau klik untuk memilih file</p>
                        </div>
                        <div id="preview"></div>
                        <p>Jumlah gambar yang di-upload: <span id="fileCount">0</span></p>

                        <div class="form-group">
                            <label for="youtubeLink">Link Video YouTube</label>
                            <input type="url" class="form-control" id="youtubeLink" name="youtubeLink" placeholder="Masukkan link video YouTube">
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-turquoise" onclick="validateForm()">Simpan</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </form>
    <div class="card">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form id="uploadFormItem" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="photo">Pilih Foto:</label>
                    <input type="file" class="form-control" name="photo[]" id="photo" accept="image/*" multiple>
                </div>
                <div id="preview-container" class="preview-container"></div>
                <input type="hidden" name="resized_photos" id="resized_photos">
                <input type="hiddesn" name="ads_id" id="ads_id">
                <button type="button" class="btn btn-success" onclick="validateForm()">Upload</button>
            </form>
            <div id="upload-status" class="mt-3"></div>
        </div>
    </div>
    </div>
    </div>

    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
    </div>
    
    @endslot
</x-Layout.Vertical.Master>