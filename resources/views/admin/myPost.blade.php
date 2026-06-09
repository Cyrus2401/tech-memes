@extends('layouts.master')

@section('container')

  <section id="blog" class="blog">

      @if($info = Session::get('info'))
        <div class="container mb-4">
          <div class="alert alert-info d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
            <div>{{ $info }}</div>
          </div>
        </div>
      @endif

      @if(session()->has('success'))
        <div class="container mb-4">
          <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session()->get('success') }}</div>
          </div>
        </div>
      @endif

      <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2 class="text-white"><i class="bi bi-collection text-primary me-2"></i>MES PUBLICATIONS</h2>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="row entries">

              @if(count($memes) > 0)

                @foreach ($memes as $meme)

                  <article class="col-12 entry shadow-lg">

                    @if($meme->title)
                      <h2 class="entry-title mb-3">
                        <a href="javascript:void(0)" class="text-dark text-decoration-none">{{ $meme->title }}</a>
                      </h2>
                    @endif

                    <div class="entry-img-container mb-4 text-center">
                      <img src="/storage/{{ $meme->image }}" alt="{{ $meme->title ?? 'Meme' }}" class="img-fluid">
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap entry-meta gap-3">
                      <ul>
                        <li><i class="bi bi-person-circle"></i> <span>Publié par <strong class="text-dark">{{ $meme->user->pseudo }}</strong></span></li>
                        <li><i class="bi bi-clock"></i> <span><time>{{ $meme->created_at->format('d/m/Y') }}</time></span></li>
                      </ul>

                      <div class="d-flex gap-2">
                        <a href="{{ route('updateMeme', $meme->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i> Modifier</a>
                        <button value="{{ $meme->id }}" class="btn btn-outline-danger btn-sm showDeleteMemeModal"><i class="bi bi-trash me-1"></i> Supprimer</button>
                      </div>
                    </div>

                  </article>
                  
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                  {!! $memes->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
              
              @else
                <div class="text-center py-5 empty-state-container mx-auto" style="max-width: 680px;">
                  <h3 class="empty-state-title text-dark">Aucun mème posté pour l'instant ! 📂</h3>
                  <p class="text-muted empty-state-desc mx-auto mb-4" style="max-width: 480px;">
                    Vous n'avez publié aucun mème sur notre plateforme pour le moment. Exprimez votre humour de développeur !
                  </p>
                  <a href="{{ route('postMemeView') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Publier mon premier mème</a>
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
      $('.showDeleteMemeModal').on('click', function() {
        var val = $(this).val();
        $('#disableUserForm').attr('action', '/deletePost/' + val);
        $('#deletePostModal').modal('show');
      });

      // GSAP Stagger animations for meme cards on page load
      if (typeof gsap !== 'undefined') {
        gsap.from('.blog .entry', {
          duration: 0.6,
          opacity: 0,
          y: 40,
          stagger: 0.15,
          ease: 'power3.out',
          clearProps: 'all'
        });
      }
    });
  </script>
@endsection