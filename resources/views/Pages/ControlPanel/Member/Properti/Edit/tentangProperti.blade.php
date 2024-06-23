<x-Layout.Vertical.Master>
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
<script>
    document.getElementById('judulIklan').addEventListener('input', function () {
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
            success: function (response) {
                if (!response.available) {
                    $('#cektitle').html(' <div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function () {
                $('#results').html('Error: Tidak dapat mengambil data');
            }
        });
    });

    // Log the initial value on page load
    document.addEventListener('DOMContentLoaded', function () {
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
    document.addEventListener('DOMContentLoaded', function () {
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
        radio.addEventListener('change', function () {
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
    document.addEventListener('DOMContentLoaded', function () {
        const checkedRadio = document.querySelector('input[name="property_type"]:checked');
        if (checkedRadio) {
            console.log(checkedRadio.value);
        }
    });
</script>
@endslot
    @slot('body')
    
    <x-Layout.Item.PropertyAdForm :ads="$ads">
    </x-Layout.Item.PropertyAdForm>

    <x-Layout.Item.PropertyDetailsForm :ads="$ads">
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
                                            <input type="checkbox" class="custom-control-input" id="other_facility{{$key}}"
                                                name="other_facility[]" value="{{$condition}}"
                                                data-parsley-multiple="groups" data-parsley-mincheck="2">
                                            <label class="custom-control-label"
                                                for="other_facility{{$key}}">{{$condition}}</label>
                                        </div>
                                    </div>
                                @empty
                                    <p>Tidak ada kondisi lingkungan yang tersedia.</p>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
    @endslot
</x-Layout.Vertical.Master>