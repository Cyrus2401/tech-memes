@extends('layouts.master')

@section('container')
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2 class="text-dark">MODIFIER LE MEME</h2>
        </div>

        <div class="row">

            <div class="col-lg-6 mx-auto">
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
                        <label for="title" class="form-label">Titre du mème</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Titre" value="{{ $meme->title }}">
                    </div>

                    <!-- Existing Image Section -->
                    <div class="form-group mb-4" id="current-image-container">
                        <label class="form-label text-muted">Image actuelle du mème</label>
                        <div class="text-center p-2 rounded border bg-light">
                            <img src="/storage/{{ $meme->image }}" class="img-fluid rounded" style="max-height: 240px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="file" class="form-label">Remplacer l'image (PNG, JPG, GIF)</label>
                        
                        <div class="custom-file-upload" id="upload-area">
                            <i class="bi bi-cloud-arrow-up text-primary display-4 mb-2 d-block"></i>
                            <span class="text-dark d-block mb-1">Glissez-déposez ou cliquez pour remplacer l'image</span>
                            <span class="text-muted small">Sélectionnez une nouvelle image pour modifier</span>
                            <input type="file" accept=".png,.jpeg,.jpg,.gif" class="d-none" name="file" id="file" required>
                        </div>
                        
                        @error('file')
                            <div class="alert alert-danger mt-3 p-2 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Image Preview Area (Hidden by default) -->
                    <div class="form-group d-none" id="preview-container">
                        <label class="form-label text-muted">Nouvel aperçu choisi</label>
                        <div class="text-center p-2 rounded border border-success bg-light">
                            <img src="" id="image-preview" class="img-fluid rounded" style="max-height: 240px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check2-circle me-2"></i>Enregistrer les modifications</button>
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

            // Handle file selection and preview
            $('#file').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#image-preview').attr('src', event.target.result);
                        $('#preview-container').removeClass('d-none');
                        $('#current-image-container').addClass('opacity-50'); // Mute old image
                        $('#upload-area').addClass('border-success').find('span').first().text(file.name);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form entrance animation
            if (typeof gsap !== 'undefined') {
                gsap.from('.php-email-form', {
                    duration: 0.6,
                    opacity: 0,
                    y: 30,
                    ease: 'power3.out'
                });
            }
        });
    </script>
@endsection