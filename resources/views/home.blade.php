@extends('layouts.master')

@section('container')

  <section id="blog" class="blog {{ count($memes) == 0 ? 'blog-empty' : '' }}">

      <div class="container">

        <div class="row justify-content-center">
          <div class="col-lg-8">

            @if($info = Session::get('info'))
              <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>{{ $info }}</div>
              </div>
            @endif

            @if(session()->has('success'))
              <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session()->get('success') }}</div>
              </div>
            @endif

            <div class="row entries">

              @if(count($memes) > 0)

                @foreach ($memes as $meme)

                  <article class="col-12 entry shadow-lg mb-4">
                    <!-- Post Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-light">
                      <div class="d-flex align-items-center gap-3">
                        <div class="user-avatar-badge text-white d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 40px; height: 40px; font-weight: 700; background: #2D6047; font-size: 16px;">
                          {{ strtoupper(substr($meme->user->pseudo, 0, 1)) }}
                        </div>
                        <div>
                          <span class="fw-bold text-dark d-block" style="font-size: 15px; letter-spacing: -0.01em;">{{ $meme->user->pseudo }}</span>
                          @if($meme->user->role == 'sadmin')
                            <span class="text-muted">
                              <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-20 py-1 px-2" style="font-size: 10px; font-weight: 600; letter-spacing: 0.05em;">TECH-MEMES</span>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="text-muted d-flex align-items-center gap-1 bg-light px-2 py-1 rounded" style="font-size: 12px; font-weight: 500;">
                        <i class="bi bi-clock text-primary"></i>
                        <span>{{ $meme->created_at->format('d/m/Y H:i:s') }}</span>
                      </div>
                    </div>

                    <!-- Post Title -->
                    @if($meme->title)
                      <h3 class="entry-title mb-3" style="font-size: 20px; font-weight: 700; letter-spacing: -0.02em;">
                        {{ $meme->title }}
                      </h3>
                    @endif

                    <!-- Post Media Container -->
                    <div class="entry-img-container mb-4 text-center rounded p-2" style="background-color: var(--bg-card-solid); overflow: hidden;">
                      <img src="{{ asset($meme->image) }}" alt="{{ $meme->title ?? 'Meme' }}" class="img-fluid rounded" style="max-height: 500px; object-fit: contain;">
                    </div>

                    <!-- Post Footer (Interactions) -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3 pt-3 border-top border-light">
                      <div class="d-flex align-items-center gap-2">
                        <!-- Likes System -->
                        @auth
                          @if($meme->isLikedBy(Auth::user()))
                            <button class="btn bg-danger-subtle btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center border meme-like-btn liked" data-meme-id="{{ $meme->id }}" title="Ne plus aimer" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                              <i class="bi bi-heart-fill text-danger"></i>
                            </button>
                          @else
                            <button class="btn btn-light btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center border meme-like-btn" data-meme-id="{{ $meme->id }}" title="Aimer" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                              <i class="bi bi-heart text-danger"></i>
                            </button>
                          @endif
                        @else
                          <button class="btn btn-light btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center border meme-like-btn" data-meme-id="{{ $meme->id }}" title="Aimer" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                            <i class="bi bi-heart text-danger"></i>
                          </button>
                        @endauth
                        <span class="like-count fw-bold text-muted small me-2">{{ $meme->likes()->count() }}</span>
                        
                        <!-- Copy link action -->
                        <button class="btn btn-light btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center border copy-meme-link" data-url="{{ asset($meme->image) }}" title="Partager" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                          <i class="bi bi-share text-secondary"></i>
                        </button>
                      </div>

                      <div class="d-flex align-items-center gap-2">
                        <!-- Download Link -->
                        <a href="{{ asset($meme->image) }}" download class="btn btn-outline-primary btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center" title="Télécharger" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                          <i class="bi bi-download"></i>
                        </a>

                        <!-- Admin Management (Sadmin only on feed) -->
                        @auth
                          @if(Auth::user()->role == "sadmin")
                            <a href="{{ route('updateMeme', $meme->id) }}" class="btn btn-outline-warning btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center" title="Modifier" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                              <i class="bi bi-pencil"></i>
                            </a>
                            <button value="{{ $meme->id }}" class="btn btn-outline-danger btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center showDeleteMemeModal" title="Supprimer" style="width: 38px; height: 38px; transition: all 0.2s ease;">
                              <i class="bi bi-trash"></i>
                            </button>
                          @endif
                        @endauth
                      </div>
                    </div>
                  </article>
                  
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                  {!! $memes->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
              
              @else
                <div class="text-center py-5 empty-state-container mx-auto" style="max-width: 680px;">
                  <h3 class="empty-state-title text-dark">Le calme plat...</h3>
                  <p class="text-muted empty-state-desc mx-auto mb-4" style="max-width: 480px;">
                    Aucun mème n'a été posté pour le moment. Revenez plus tard ou devenez admin pour publier le tout premier !
                  </p>
                  @guest
                    <a href="{{ route('becomeAdmin') }}" class="btn btn-primary"><i class="bi bi-shield-lock me-2"></i>Devenir Admin & Publier</a>
                  @endguest
                </div>
              @endif

            </div>
          </div>
        </div>

      </div>
  </section>

  {{-- Modal de suppression du post --}}
  <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deletePostModalLabel"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Supprimer la publication</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer ce mème ? Cette action est irréversible.
            </div>
            <form action="" id="disableUserForm" method="POST">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection

@section('script')
    <script>
      $(document).ready(function() {
        $(document).on('click', '.showDeleteMemeModal', function() {
          var val = $(this).val();
          $('#disableUserForm').attr('action', '/deletePost/' + val);
          var modalEl = document.getElementById('deletePostModal');
          if (modalEl) {
            var myModal = new bootstrap.Modal(modalEl);
            myModal.show();
          }
        });

        // Clipboard share link
        $(document).on('click', '.copy-meme-link', function(e) {
            var url = $(this).data('url');
            var tempInput = document.createElement('textarea');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Show toast notification
            var toast = $('<div class="toast-share bg-dark text-white py-2 px-3 rounded shadow-lg" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; font-size: 14px; opacity: 0; transition: opacity 0.3s ease;"><i class="bi bi-check-circle-fill text-success me-2"></i>Lien du mème copié !</div>');
            $('body').append(toast);
            setTimeout(function() {
                toast.css('opacity', '1');
            }, 100);
            setTimeout(function() {
                toast.css('opacity', '0');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }, 2500);
        });

        // Likes toggle
        $(document).on('click', '.meme-like-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var memeId = btn.data('meme-id');
            var countSpan = btn.next('.like-count');

            $.ajax({
                url: '/meme/' + memeId + '/like',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        countSpan.text(response.count);
                        if (response.liked) {
                            btn.addClass('liked bg-danger-subtle').removeClass('btn-light');
                            btn.find('i').removeClass('bi-heart').addClass('bi-heart-fill');
                            btn.attr('title', 'Ne plus aimer');
                        } else {
                            btn.removeClass('liked bg-danger-subtle').addClass('btn-light');
                            btn.find('i').removeClass('bi-heart-fill').addClass('bi-heart');
                            btn.attr('title', 'Aimer');
                        }
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        // User not authenticated, show a warning toast
                        var toast = $('<div class="toast-share bg-danger text-white py-2 px-3 rounded shadow-lg" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; font-size: 14px; opacity: 0; transition: opacity 0.3s ease;"><i class="bi bi-exclamation-circle-fill me-2"></i>Vous devez être connecté pour aimer un mème !</div>');
                        $('body').append(toast);
                        setTimeout(function() {
                            toast.css('opacity', '1');
                        }, 100);
                        setTimeout(function() {
                            toast.css('opacity', '0');
                            setTimeout(function() {
                                toast.remove();
                            }, 300);
                        }, 3000);
                    }
                }
            });
        });

        @guest
        // GSAP Stagger animations for meme cards on page load
        if (typeof gsap !== 'undefined') {
          gsap.from('.blog .entry', {
            duration: 0.4,
            opacity: 0,
            y: 40,
            stagger: 0.1,
            ease: 'power3.out',
            clearProps: 'all'
          });
        }
        @endguest
      });
    </script>
@endsection