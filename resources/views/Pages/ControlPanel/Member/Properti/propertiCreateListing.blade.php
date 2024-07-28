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

            console.log('Increment Buttons:', incrementButtons.length);
            console.log('Decrement Buttons:', decrementButtons.length);

            incrementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.previousElementSibling;
                    input.value = parseInt(input.value, 10) + 1;
                    console.log('Incremented Value:', input.value);
                });
            });

            decrementButtons.forEach(button => {
                button.addEventListener('click', function() {
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
            console.log(this.value);
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
        // Fungsi untuk menghitung dan menampilkan jumlah karakter
        function updateCharCount() {
            var textarea = document.getElementById('elm1');
            var charCount = document.getElementById('charCount');
            console.log(textarea);
            charCount.textContent = textarea.value.length + ' karakter';
        }


        // Initialize the character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('sdf');
            var textarea = document.getElementById('elm1');
            var charCount = document.getElementById('charCount');
            charCount.textContent = textarea.value.length + ' karakter';
        });
    </script>

    <script>
        // Get all radio buttons with name 'property_type'
        // Get all radio buttons with name 'property_type'
        const radios = document.querySelectorAll('input[name="property_type"]');

        // Add an event listener to each radio button
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    console.log(this.value);
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

        // Log the initially selected value on page load (if any)
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="property_type"]:checked');
            if (checkedRadio) {
                console.log(checkedRadio.value);
            }
        });
    </script>
    <script>
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

            // Clear previous error messages
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
                submitForm();
            } else {
                alert("Please fill in all required fields.");
            }
        }


        function submitForm() {
            const formData = {
                district_id: document.getElementById('district_id').value.trim(),
                district_name: document.getElementById('district_name').value.trim(),
                lat: document.getElementById('lat').value.trim(),
                lng: document.getElementById('lng').value.trim(),
                area: document.getElementById('area').value.trim(),
                adres: document.getElementById('adres').value.trim(),

                ads_type: document.querySelector('input[name="ads_type"]:checked').value,
                property_type: document.querySelector('input[name="property_type"]:checked').value,
                title: document.getElementById('judulIklan').value.trim(),
                description: document.getElementById('descriptionIklan').value.trim(),
                price: document.getElementById('harga').value.trim(),
                housing_name: document.getElementById('housing_name').value.trim(),
                cluster_name: document.getElementById('cluster_name').value.trim(),
                lt: document.getElementById('lt').value.trim(),
                lb: document.getElementById('lb').value.trim(),
                year_built: document.getElementById('year_built').value.trim(),
                dl: document.getElementById('dl').value.trim(),
                certificates: Array.from(document.querySelectorAll('input[name="certificate[]"]:checked')).map(el => el.value),
                jk: document.getElementById('jk').value.trim(),
                jkm: document.getElementById('jkm').value.trim(),
                jl: document.getElementById('jl').value.trim(),
                youtubeLink: document.getElementById('youtubeLink').value.trim(),
                house_facilities: Array.from(document.querySelectorAll('input[name="house_facility[]"]:checked')).map(el => el.value),
                furniture_condition: document.querySelector('input[name="furniture_condition"]:checked').value,
                other_facilities: Array.from(document.querySelectorAll('input[name="other_facility[]"]:checked')).map(el => el.value)
            };
            console.log('formData', formData);
            $.ajax({
                url: "{{route('member.properti.store.listing')}}", // Replace with your server endpoint URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Data berhasil disimpan!');
                    // Additional success handling if needed
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat menyimpan data: ' + error);
                    // Additional error handling if needed
                }
            });
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
    @endslot
    @slot('body')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <!-- <div class="btn-group float-right">
                    <a href="{{route('member.properti.create')}}" class="btn btn-turquoise">Pasang Iklan</a>
                </div> -->
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

            <form action="{{route('member.properti.store.listing')}}" method="post" enctype="multipart/form-data">

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

                        <!-- Input untuk link video YouTube -->
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
    </div>
    </form>
    @endslot

</x-Layout.Vertical.Master>