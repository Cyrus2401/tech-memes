@extends('layouts.master')

@section('container')
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2 class="text-dark"><i class="bi bi-shield-check text-primary me-2"></i>LISTE DES ADMINISTRATEURS</h2>
        </div>

        @if($message = Session::get('success'))
            <div class="container mb-4">
                <div class="alert alert-success d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ $message }}</div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12 p-3 bg-card-solid rounded-lg border shadow-lg">
                @if (count($admins) > 0)
                    <div class="table-responsive">
                        <table id="table" class="table table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-2"></i>Pseudo</th>
                                    <th><i class="bi bi-envelope me-2"></i>Email</th>
                                    <th><i class="bi bi-calendar-event me-2"></i>Admin depuis le</th>
                                    <th><i class="bi bi-activity me-2"></i>Statut</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $admin->pseudo }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td class="font-monospace small">{{ $admin->created_at->format('d/m/Y à H:i') }}</td>
                                        <td>
                                            @if($admin->statut == 1)
                                                <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i>Activé</span>
                                            @else
                                                <span class="badge bg-danger"><i class="bi bi-shield-x me-1"></i>Désactivé</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($admin->statut == 1)
                                                <button value="{{ $admin->id }}" class="btn btn-outline-danger btn-sm showDisableAdminModal"><i class="bi bi-shield-slash me-1"></i>Désactiver</button>
                                            @else
                                                <button value="{{ $admin->id }}" class="btn btn-success btn-sm showAbleAdminModal"><i class="bi bi-shield-check me-1"></i>Activer</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 empty-state-container mx-auto" style="max-width: 680px;">
                        <h3 class="empty-state-title text-dark">Aucun administrateur trouvé 🔒</h3>
                        <p class="text-muted empty-state-desc mx-auto">
                            Il n'y a aucun administrateur dans le système actuellement.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        </div>
    </section>

    {{-- Modal de desactivation de l'admin --}}
    <div class="modal fade" id="disableAdminModal" tabindex="-1" aria-labelledby="disableAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="disableAdminModalLabel"><i class="bi bi-shield-exclamation text-danger me-2"></i>Désactiver l'administrateur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment désactiver cet administrateur ? Il perdra immédiatement ses accès de publication.
                </div>
                <form action="/disableAdmin/" id="disableUserForm" method="POST">
                    @csrf
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Désactiver l'admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal d'activation de l'admin --}}
    <div class="modal fade" id="ableAdminModal" tabindex="-1" aria-labelledby="ableAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ableAdminModalLabel"><i class="bi bi-shield-check text-success me-2"></i>Activer l'administrateur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment réactiver cet administrateur ? Ses accès de publication seront restaurés.
                </div>
                <form action="/ableAdmin/" id="ableUserForm" method="POST">
                    @csrf
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Activer l'admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.showDisableAdminModal').on('click', function() {
                var val = $(this).val();
                $('#disableAdminModal').modal('show');
                $('#disableUserForm').attr('action', '/disableAdmin/' + val);
            });

            $('.showAbleAdminModal').on('click', function() {
                var val = $(this).val();
                $('#ableAdminModal').modal('show');
                $('#ableUserForm').attr('action', '/ableAdmin/' + val);
            });

            // GSAP Row entrance stagger animation
            if (typeof gsap !== 'undefined') {
                gsap.from('tbody tr', {
                    duration: 0.5,
                    opacity: 0,
                    x: -20,
                    stagger: 0.08,
                    ease: 'power3.out'
                });
            }
        });
    </script>
@endsection