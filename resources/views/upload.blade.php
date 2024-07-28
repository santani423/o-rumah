<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Upload Foto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form id="upload-form" action="{{ route('upload.photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="photo">Pilih Foto:</label>
                <input type="file" class="form-control" name="photo[]" id="photo" accept="image/*" multiple>
            </div>
            <div id="preview-container" class="preview-container"></div>
            <input type="hidden" name="resized_photos" id="resized_photos">
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('preview-container');
            var resizedPhotosInput = document.getElementById('resized_photos');
            var resizedPhotos = resizedPhotosInput.value ? JSON.parse(resizedPhotosInput.value) : [];

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

                            // Convert canvas to base64 string
                            var resizedDataUrl = canvas.toDataURL('image/jpeg');
                            resizedPhotos.push(resizedDataUrl);

                            // Create image preview
                            var imgPreview = document.createElement('img');
                            imgPreview.src = resizedDataUrl;
                            imgPreview.className = 'preview-img';

                            // Create remove button
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

                            // Create container for image and remove button
                            var imgPreviewContainer = document.createElement('div');
                            imgPreviewContainer.className = 'img-preview-container';
                            imgPreviewContainer.appendChild(imgPreview);
                            imgPreviewContainer.appendChild(removeButton);
                            previewContainer.appendChild(imgPreviewContainer);

                            // Update hidden input value
                            resizedPhotosInput.value = JSON.stringify(resizedPhotos);
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById('upload-form').addEventListener('submit', function(event) {
                if (resizedPhotos.length === 0) {
                    event.preventDefault();
                    alert('Tunggu sampai gambar selesai diubah ukurannya.');
                }
            });
        });
    </script>
</body>
</html>
