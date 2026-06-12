@extends('layouts.master')

@section('container')
    <section id="contact" class="contact">
        <div class="container mt-connected">

        <div class="section-title">
            <h2 class="text-dark">PUBLIER UN MEME</h2>
        </div>

        <div class="row">

            <div class="col-lg-10 mx-auto">
                <form method="post" role="form" class="php-email-form shadow-lg" enctype="multipart/form-data">
                    @csrf

                    @if($error = session()->get('error'))
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>{{ $error }}</div>
                        </div>
                    @endif

                    @if($success = session()->get('success'))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ $success }}</div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="title" class="form-label">Titre du mème (optionnel)</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="file" class="form-label">Image du mème (PNG, JPG, JPEG, GIF)</label>
                        
                        <div class="custom-file-upload" id="upload-area">
                            <i class="bi bi-cloud-arrow-up text-primary display-4 mb-2 d-block"></i>
                            <span class="text-dark d-block mb-1">Glissez-déposez ou cliquez pour choisir un fichier</span>
                            <span class="text-muted small">Taille maximale : 2 Mo</span>
                        </div>
                        <input type="file" accept=".png,.jpeg,.jpg,.gif,.PNG,.JPEG,.JPG,.GIF,image/png,image/jpeg,image/gif" class="d-none" name="file" id="file">
                        
                        @error('file')
                            <div class="alert alert-danger mt-3 p-2 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview Area -->
                    <div class="form-group d-none" id="preview-container">
                        <label class="form-label text-muted">Aperçu du mème</label>
                        <div class="text-center p-2 rounded border bg-light">
                            <img src="" id="image-preview" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-cloud-upload me-2"></i>Publier le mème</button>
                    </div>
                </form>
            </div>

        </div>

        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Trigger input file click on drag/drop zone click
            $('#upload-area').on('click', function() {
                $('#file').click();
            });

            $('#file').on('click', function(e) {
                e.stopPropagation();
            });

            // Handle file selection and preview
            $('#file').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#image-preview').attr('src', event.target.result);
                        $('#preview-container').removeClass('d-none');
                        // Custom styling changes for selected file
                        $('#upload-area').removeClass('border-danger').addClass('border-success').find('span').first().text(file.name);
                        $('#file-warning').remove();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Client-side validation on form submit
            $('form').on('submit', function(e) {
                var fileInput = $('#file');
                if (fileInput.length && !fileInput[0].files.length) {
                    e.preventDefault();
                    $('#upload-area').addClass('border-danger');
                    // Add a temporary warning message if not already present
                    if (!$('#file-warning').length) {
                        $('<div id="file-warning" class="text-danger small mt-2 ms-1"><i class="bi bi-exclamation-circle me-1"></i>Veuillez choisir un fichier image.</div>').insertAfter('#upload-area');
                    }
                }
            });

        });
    </script>
@endsection