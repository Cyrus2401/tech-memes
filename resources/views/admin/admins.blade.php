@extends('layouts.master')

@section('container')
    <section id="contact" class="contact">
        <div class="container-fluid px-md-5 mt-connected" style="max-width: 1400px; margin: 0 auto;">

        @php
            $totalAdmins = count($admins);
            $activeAdmins = $admins->where('statut', 1)->count();
            $inactiveAdmins = $admins->where('statut', 0)->count();
        @endphp

        <div class="section-title">
            <h2 class="text-dark">ADMINISTRATEURS</h2>
        </div>

        @if($message = Session::get('success'))
            <div class="container mb-4">
                <div class="alert alert-success d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ $message }}</div>
                </div>
            </div>
        @endif

        @if($message = Session::get('error'))
            <div class="container mb-4">
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ $message }}</div>
                </div>
            </div>
        @endif

        {{-- Statistics Row --}}
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card p-3 rounded-lg shadow border" style="background-color: var(--bg-card-solid); border-color: var(--color-border) !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small uppercase fw-bold d-block mb-1">Total Administrateurs</span>
                            <h3 class="fw-bold text-primary mb-0">{{ $totalAdmins }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 rounded-lg shadow border" style="background-color: var(--bg-card-solid); border-color: var(--color-border) !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small uppercase fw-bold d-block mb-1">Actifs</span>
                            <h3 class="fw-bold text-success mb-0">{{ $activeAdmins }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 rounded-lg shadow border" style="background-color: var(--bg-card-solid); border-color: var(--color-border) !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small uppercase fw-bold d-block mb-1">Inactifs</span>
                            <h3 class="fw-bold text-danger mb-0">{{ $inactiveAdmins }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-4 ms-auto">
                <div class="d-flex align-items-center justify-content-md-end mb-2 mb-md-0">
                    <label for="statusFilter" class="text-muted small me-2 mb-0" style="white-space: nowrap;"><i class="bi bi-funnel me-1"></i>Filtrer par statut :</label>
                    <select id="statusFilter" class="form-select form-select-sm border" style="background-color: var(--bg-card); border-color: var(--color-border); border-radius: 8px; width: 160px; padding: 8px 16px;">
                        <option value="all">Tous</option>
                        <option value="active">Actifs</option>
                        <option value="inactive">Inactifs</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 p-3 bg-card-solid rounded-lg border shadow-lg">
                @if (count($admins) > 0)
                    <div class="table-responsive">
                        <table id="table" class="table-custom table table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-2"></i>Pseudo</th>
                                    <th><i class="bi bi-envelope me-2"></i>Email</th>
                                    <th><i class="bi bi-calendar-event me-2"></i>Admin depuis le</th>
                                    <th><i class="bi bi-activity me-2"></i>Statut</th>
                                    <th class="text-end"><i class="bi bi-gear me-2"></i>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr data-status="{{ $admin->statut == 1 ? 'active' : 'inactive' }}">
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
                                            @if($admin->id == Auth::user()->id)
                                                <span class="text-muted small fw-medium" title="Vous ne pouvez pas désactiver votre propre compte"><i class="bi bi-shield-lock me-1"></i>Vous (Actif)</span>
                                            @else
                                                @if($admin->statut == 1)
                                                    <button value="{{ $admin->id }}" class="btn btn-link text-danger p-1 showDisableAdminModal" title="Désactiver"><i class="bi bi-toggle-on fs-3"></i></button>
                                                @else
                                                    <button value="{{ $admin->id }}" class="btn btn-link text-muted p-1 showAbleAdminModal" title="Activer"><i class="bi bi-toggle-off fs-3"></i></button>
                                                @endif
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
            // Use event delegation for dynamic DataTable rows with native Bootstrap 5 Modals
            $(document).on('click', '.showDisableAdminModal', function() {
                var val = $(this).val();
                $('#disableUserForm').attr('action', '/disableAdmin/' + val);
                var modalEl = document.getElementById('disableAdminModal');
                var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            });

            $(document).on('click', '.showAbleAdminModal', function() {
                var val = $(this).val();
                $('#ableUserForm').attr('action', '/ableAdmin/' + val);
                var modalEl = document.getElementById('ableAdminModal');
                var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            });

            // Register status filter for DataTables
            if ($.fn.dataTable) {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var statusFilter = $('#statusFilter').val();
                        if (!statusFilter || statusFilter === 'all') {
                            return true;
                        }
                        var rowStatus = $(settings.aoData[dataIndex].nTr).data('status');
                        return rowStatus === statusFilter;
                    }
                );

                $('#statusFilter').on('change', function() {
                    $('#table').DataTable().draw();
                });
            }
        });
    </script>
@endsection