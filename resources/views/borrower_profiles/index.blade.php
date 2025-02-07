@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5 text-primary font-weight-bold">Liste des profils de prêt</h1>
        <a href="{{ route('borrower_profiles.create') }}" class="btn btn-success mb-4">
            <i class="fas fa-user-plus"></i> Ajouter un profil emprunteur
        </a>

        <!-- Table des profils -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered shadow-lg">
                <thead class="thead-dark">
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowerProfiles as $profile)
                        <tr>
                            <td>
                                <a href="{{ route('borrower_profiles.show', $profile->id) }}" class="text-primary font-weight-bold">
                                    {{ $profile->first_name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('borrower_profiles.show', $profile->id) }}" class="text-primary font-weight-bold">
                                    {{ $profile->last_name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('borrower_profiles.show', $profile->id) }}" class="text-primary font-weight-bold">
                                    {{ $profile->email }}
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit"
                                        data-profile-id="{{ $profile->id }}"
                                        data-first-name="{{ $profile->first_name }}"
                                        data-last-name="{{ $profile->last_name }}"
                                        data-email="{{ $profile->email }}"
                                        data-action-url="{{ route('borrower_profiles.update', ['id' => $profile->id]) }}">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <!-- Formulaire de suppression -->
                                <form class="d-inline delete-form" data-profile-id="{{ $profile->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal pour modifier un profil -->
        <div id="editModal" class="modal">
            <div class="modal-overlay"></div> <!-- Fond sombre pour modal -->
            <div class="modal-content rounded-lg shadow-lg">
                <span id="closeModal" class="close">&times;</span>
                <h2 class="text-center text-primary font-weight-bold">Modifier le profil</h2>
                <form id="editForm" method="POST" action="{{ route('borrower_profiles.update', ['id' => ':id']) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="profile_id"> <!-- Hidden input pour l'ID du profil -->

                    <div class="form-group mb-3">
                        <label for="first_name" class="font-weight-bold">Prénom</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="last_name" class="font-weight-bold">Nom</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sauvegarder</button>
                </form>
            </div>
        </div>
    </div>

    <style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin-top: 66px;
    }

    h1 {
        font-size: 2rem;
        color: #145fad;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 1rem;
        transition: transform 0.3s ease-in-out, background-color 0.3s;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    .btn-success {
        background-color: #42b983;
        border-color: #42b983;
    }

    .btn-success:hover {
        background-color: #358c63;
        border-color: #358c63;
    }

    .btn-warning {
        background-color: #f1c40f;
        border-color: #f1c40f;
    }

    .btn-warning:hover {
        background-color: #f39c12;
        border-color: #f39c12;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    /* Table Styles */
    .table {
        width: 100%;
        margin-top: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    thead {
        background-color: #145fad;
        color: white;
    }

    th, td {
        padding: 15px;
        text-align: center;
        font-size: 1rem;
        vertical-align: middle;
    }

    tbody tr {
        background-color: #ffffff;
        color: #333333;
    }

    tbody tr:hover {
        background-color: #f7f7f7;
        cursor: pointer;
    }

    tr {
        color: #333;
    }

    /* Modal Styles */
    .modal {
        display: none; /* Initialement caché */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 1.5rem;
        color: #aaa;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }

    /* Input Fields */
    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 15px;
        margin-top: 8px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 1rem;
    }

    .btn-block {
        width: 100%;
        font-size: 1.1rem;
    }

    .text-primary {
        color: #145fad !important;
    }

    .text-primary:hover {
        color: #0d78c6 !important;
    }
</style>

    <script>
        // Récupérer les éléments
        const modal = document.getElementById("editModal");
        const closeModal = document.getElementById("closeModal");
        const editButtons = document.querySelectorAll('.btn-edit');
        const editForm = document.getElementById('editForm');

        // Ouvrir le modal au clic du bouton "Modifier"
        editButtons.forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                const profileId = this.getAttribute('data-profile-id');
                const actionUrl = editForm.action.replace(':id', profileId);

                // Mettre à jour l'URL de l'action du formulaire
                editForm.action = actionUrl;

                // Remplir le formulaire avec les données du profil
                document.getElementById('first_name').value = this.getAttribute('data-first-name');
                document.getElementById('last_name').value = this.getAttribute('data-last-name');
                document.getElementById('email').value = this.getAttribute('data-email');

                // Afficher le modal
                modal.style.display = "block";
            });
        });

        // Fermer le modal
        closeModal.addEventListener("click", function() {
            modal.style.display = "none";
        });

        // Fermer le modal si on clique en dehors de celui-ci
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });

        // Suppression avec fetch()
        document.querySelectorAll('.delete-form').forEach(form => {
            form.querySelector('.btn-delete').addEventListener('click', function(event) {
                event.preventDefault();
                const profileId = form.getAttribute('data-profile-id');

                if (confirm('Voulez-vous confirmer la suppression de ce profil ?')) {
                    fetch(`/borrower_profiles/${profileId}`, {
                        method: 'DELETE',  // Utiliser DELETE pour supprimer le profil
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Assurez-vous que le token CSRF est inclus
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);  // Afficher le message de succès
                            location.reload();  // Recharger la page pour mettre à jour les données
                        } else {
                            alert('Erreur : ' + data.message);  // Afficher un message d'erreur
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue.');
                    });
                }
            });
        });
    </script>
@endsection
