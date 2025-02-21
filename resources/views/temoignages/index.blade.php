<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Témoignages - Ramadan 2025</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-olive: #2C3315;
            --color-gold: #D4B363;
            --color-light-gold: #E5C785;
        }
        body { font-family: 'Lato', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-olive { background-color: var(--color-olive); }
        .text-gold { color: var(--color-gold); }
        .text-light-gold { color: var(--color-light-gold); }
        .border-gold { border-color: var(--color-gold); }
        .gold-glow { text-shadow: 0 0 15px rgba(212, 179, 99, 0.4); }
        .modal { display: none; position: fixed; z-index: 50; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.7); }
        .modal-content { background-color: var(--color-olive); margin: 10% auto; padding: 20px; border: 1px solid var(--color-gold); width: 80%; max-width: 700px; border-radius: 8px; }
        .golden-button { background: linear-gradient(135deg, #D4B363 0%, #F2D795 50%, #D4B363 100%); box-shadow: 0 4px 15px rgba(212, 179, 99, 0.3); border: 1px solid rgba(212, 179, 99, 0.6); text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); }
        .golden-button:hover { background: linear-gradient(135deg, #E5C785 0%, #F2D795 50%, #E5C785 100%); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(212, 179, 99, 0.4); }
    </style>
</head>
<body class="bg-olive min-h-screen">
    <nav class="py-6">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-display text-gold">RamadOn</div>
                <div class="space-x-8">
                    <a href="/recettes" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                    <a href="/temoignages" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-display text-gold text-center mb-12 gold-glow">Nos Témoignages du Ramadan</h1>
        
        <div class="mb-12">
            <div class="flex justify-end">
                <button id="addTemoignageBtn" class="golden-button px-8 py-3 text-olive rounded-full transition-all flex items-center gap-3 font-semibold tracking-wide">
                    <i class="fas fa-plus text-sm bg-white/20 p-1 rounded-full"></i>
                    <span>Ajouter un témoignage</span>
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="temoignageGrid">
            @foreach($temoignages as $temoignage)
            <div class="temoignage-card bg-olive border border-gold/30 rounded-lg overflow-hidden hover:border-gold transition-all" 
                 data-id="{{ $temoignage->id }}">
                <div class="p-6">
                    <span class="text-light-gold text-sm uppercase tracking-wider">{{ $temoignage->auteur }}</span>
                    <h3 class="font-display text-gold text-xl mt-2 mb-4">{{ $temoignage->title }}</h3>
                    <div class="flex flex-col space-y-4">
                        <a href="{{ route('temoignages.show', $temoignage->id) }}" class="w-full block">
                            <button class="voir-temoignage-btn w-full px-4 py-2 border border-gold/30 rounded-full text-light-gold hover:text-gold hover:border-gold transition-all">
                                Voir Témoignage →
                            </button>
                        </a>
                        <div class="flex justify-end space-x-2">
                            <button class="edit-btn p-2 text-light-gold hover:text-gold transition-all">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn p-2 text-light-gold hover:text-gold transition-all">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <div id="editTemoignageModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-display text-gold text-3xl gold-glow" id="editModalTitle">Ajouter un témoignage</h2>
            <button class="close-modal text-gold hover:text-light-gold">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="temoignageForm" class="space-y-8">
            @csrf
            <input type="hidden" id="temoignageId" name="id">
            <div class="space-y-2">
                <label class="block text-light-gold">Image</label>
                <div class="border-2 border-dashed border-gold/30 rounded-lg p-8 text-center relative">
                    <input type="file" id="temoignageImage" name="image" accept="image/*" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <p class="text-light-gold">Glissez une image ou cliquez</p>
                    <p class="text-gold/60 text-sm mt-2" id="selectedFileName">Aucun fichier sélectionné</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="temoignageAuteur" class="block text-light-gold mb-2">Auteur</label>
                    <input type="text" id="temoignageAuteur" name="auteur" 
                           class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required>
                </div>
                <div>
                    <label for="temoignageTitle" class="block text-light-gold mb-2">Titre</label>
                    <input type="text" id="temoignageTitle" name="title" 
                           class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required>
                </div>
            </div>
            <div>
                <label for="temoignageContent" class="block text-light-gold mb-2">Contenu</label>
                <textarea id="temoignageContent" name="content" rows="12" 
                          class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required></textarea>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="golden-button px-8 py-3 text-olive rounded-full transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Enregistrer</span>
                </button>
            </div>
        </form>
    </div>
</div>

    <div id="confirmModal" class="modal">
        <div class="modal-content max-w-md">
            <h2 class="font-display text-gold text-xl mb-6">Confirmation</h2>
            <p class="text-light-gold mb-8">Êtes-vous sûr de vouloir supprimer ce témoignage?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="px-4 py-2 border border-gold/50 text-gold rounded hover:border-gold">Annuler</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
            </div>
        </div>
    </div>

    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const temoignageGrid = document.getElementById('temoignageGrid');
            const editTemoignageModal = document.getElementById('editTemoignageModal');
            const confirmModal = document.getElementById('confirmModal');
            const addTemoignageBtn = document.getElementById('addTemoignageBtn');
            let currentTemoignageId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    currentTemoignageId = e.target.closest('.temoignage-card').dataset.id;

                    fetch(`/temoignages/${currentTemoignageId}`, { headers: { 'Accept': 'application/json' } })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editModalTitle').textContent = 'Modifier le témoignage';
                            document.getElementById('temoignageId').value = data.id;
                            document.getElementById('temoignageAuteur').value = data.auteur;
                            document.getElementById('temoignageTitle').value = data.title;
                            document.getElementById('temoignageContent').value = data.content;
                            document.getElementById('selectedFileName').textContent = 'Aucun fichier sélectionné';
                            editTemoignageModal.style.display = 'block';
                        });
                });
            });

            addTemoignageBtn.addEventListener('click', () => {
                document.getElementById('editModalTitle').textContent = 'Ajouter un témoignage';
                document.getElementById('temoignageForm').reset();
                document.getElementById('temoignageId').value = '';
                editTemoignageModal.style.display = 'block';
            });

            document.getElementById('temoignageForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const temoignageId = formData.get('id');
                const url = temoignageId ? `/temoignages/${temoignageId}` : '/temoignages';
                const method = 'POST';

                fetch(url, {
                    method: method,
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur de sauvegarde');
                    return response.json();
                })
                .then(() => window.location.reload())
                .catch(error => alert('Erreur lors de l\'enregistrement: ' + error.message));
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    currentTemoignageId = e.target.closest('.temoignage-card').dataset.id;
                    confirmModal.style.display = 'block';
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', () => {
                fetch(`/temoignages/${currentTemoignageId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.temoignage-card[data-id="${currentTemoignageId}"]`).remove();
                        confirmModal.style.display = 'none';
                        alert('Témoignage supprimé avec succès');
                    }
                })
                .catch(error => alert('Erreur lors de la suppression: ' + error.message));
            });

            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', () => {
                    editTemoignageModal.style.display = 'none';
                    confirmModal.style.display = 'none';
                });
            });
            document.getElementById('cancelDelete').addEventListener('click', () => confirmModal.style.display = 'none');
            window.addEventListener('click', (e) => {
                if (e.target === editTemoignageModal || e.target === confirmModal) {
                    editTemoignageModal.style.display = 'none';
                    confirmModal.style.display = 'none';
                }
            });
            document.getElementById('temoignageImage').addEventListener('change', function() {
                document.getElementById('selectedFileName').textContent = this.files.length > 0 ? this.files[0].name : 'Aucun fichier sélectionné';
            });
        });
    </script>
</body>
</html>