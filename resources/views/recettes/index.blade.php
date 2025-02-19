<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recettes - Ramadan 2025</title>
    
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
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
        }
        .modal-content {
            background-color: var(--color-olive);
            margin: 10% auto;
            padding: 20px;
            border: 1px solid var(--color-gold);
            width: 80%;
            max-width: 700px;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-olive min-h-screen">
    <nav class="py-6">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <div class="text-2xl font-display text-gold">RamadOn</div>
            <div class="flex items-center space-x-8">
                <div class="space-x-8">
                    <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                    <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
                </div>
                <button id="addRecipeBtn" class="ml-8 px-4 py-2 bg-gold text-olive rounded-full hover:bg-light-gold transition-all flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter une recette
                </button>
            </div>
        </div>
    </nav>
    
    <main class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-display text-gold text-center mb-12 gold-glow">Nos Recettes du Ramadan</h1>
        
        <!-- Category Filter -->
        <div class="flex justify-center mb-12 space-x-4 flex-wrap">
            <button class="category-filter active px-6 py-2 rounded-full text-gold border border-gold hover:bg-gold hover:text-olive transition-all mb-2" data-category="all">
                Toutes les recettes
            </button>
            @foreach($categories as $category)
            <button class="category-filter px-6 py-2 rounded-full text-light-gold border border-gold/30 hover:border-gold hover:text-gold transition-all mb-2" data-category="{{ $category->slug }}">
                {{ $category->name }}
            </button>
            @endforeach
        </div>
        
        <!-- Recipe Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="recipeGrid">
            @foreach($recettes as $recette)
            <div class="recipe-card bg-olive border border-gold/30 rounded-lg overflow-hidden hover:border-gold transition-all cursor-pointer" 
                 data-category="{{ $recette->category->slug }}" 
                 data-id="{{ $recette->id }}">
                <div class="p-6">
                    <span class="text-light-gold text-sm uppercase tracking-wider">{{ $recette->category->name }}</span>
                    <h3 class="font-display text-gold text-xl mt-2 mb-4">{{ $recette->name }}</h3>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button class="edit-btn p-2 text-light-gold hover:text-gold" onclick="event.stopPropagation();">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn p-2 text-light-gold hover:text-gold" onclick="event.stopPropagation();">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
    
    <!-- Recipe Detail Modal -->
    <div id="recipeModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <span class="text-light-gold text-sm uppercase tracking-wider" id="modalCategory"></span>
                <button class="close-modal text-gold hover:text-light-gold">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <h2 class="font-display text-gold text-2xl mb-6" id="modalTitle"></h2>
            <img id="modalImage" src="" alt="Image de la recette" class="w-full h-64 object-cover mb-6 rounded">
            <div class="mb-8">
                <h3 class="text-gold font-display text-xl mb-3">Ingrédients</h3>
                <ul id="modalIngredients" class="text-light-gold list-disc pl-5 space-y-2">
                    <!-- Ingredients will be loaded dynamically -->
                </ul>
            </div>
            <div>
                <h3 class="text-gold font-display text-xl mb-3">Préparation</h3>
                <p id="modalContent" class="text-light-gold leading-relaxed">
                    <!-- Recipe content will be loaded dynamically -->
                </p>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Recipe Modal -->
    <div id="editRecipeModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-display text-gold text-2xl" id="editModalTitle">Ajouter une recette</h2>
                <button class="close-modal text-gold hover:text-light-gold">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="recipeForm" class="space-y-6">
                @csrf
                <input type="hidden" id="recipeId" name="id">
                <div>
                    <label for="recipeName" class="block text-light-gold mb-2">Titre</label>
                    <input type="text" id="recipeName" name="name" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required>
                </div>
                <div>
                    <label for="recipeCategory" class="block text-light-gold mb-2">Catégorie</label>
                    <select id="recipeCategory" name="category_id" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="recipeImage" class="block text-light-gold mb-2">Image</label>
                    <input type="file" id="recipeImage" name="image" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none">
                </div>
                <div>
                    <label for="recipeIngredients" class="block text-light-gold mb-2">Ingrédients (un par ligne)</label>
                    <textarea id="recipeIngredients" name="ingredients" rows="5" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required></textarea>
                </div>
                <div>
                    <label for="recipeContent" class="block text-light-gold mb-2">Instructions</label>
                    <textarea id="recipeContent" name="content" rows="8" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-gold text-olive rounded hover:bg-light-gold transition-all">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content max-w-md">
            <h2 class="font-display text-gold text-xl mb-6">Confirmation</h2>
            <p class="text-light-gold mb-8">Êtes-vous sûr de vouloir supprimer cette recette?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="px-4 py-2 border border-gold/50 text-gold rounded hover:border-gold transition-all">Annuler</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-all">Supprimer</button>
            </div>
        </div>
    </div>
    
    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025 - Que ce mois soit rempli de bénédictions</p>
    </footer>

    <script>
        // DOM elements
        const recipeGrid = document.getElementById('recipeGrid');
        const recipeModal = document.getElementById('recipeModal');
        const editRecipeModal = document.getElementById('editRecipeModal');
        const confirmModal = document.getElementById('confirmModal');
        const categoryFilters = document.querySelectorAll('.category-filter');
        const addRecipeBtn = document.getElementById('addRecipeBtn');
        let currentRecipeId = null;
        
        // CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Open recipe detail modal
        function openRecipeModal(id) {
            // Show loading state
            document.getElementById('modalTitle').textContent = 'Chargement...';
            document.getElementById('modalCategory').textContent = '';
            document.getElementById('modalIngredients').innerHTML = '';
            document.getElementById('modalContent').textContent = '';
            recipeModal.style.display = 'block';
            
            // Fetch recipe details
            fetch(`/api/recettes/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors du chargement de la recette');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modalTitle').textContent = data.name;
                    document.getElementById('modalCategory').textContent = data.category.name;
                    document.getElementById('modalImage').src = data.image || '/images/placeholder-recipe.jpg';
                    
                    // Parse ingredients (assuming they are stored as JSON array or line breaks)
                    const ingredientsList = document.getElementById('modalIngredients');
                    ingredientsList.innerHTML = '';
                    
                    const ingredients = Array.isArray(data.ingredients) 
                        ? data.ingredients 
                        : data.ingredients.split('\n');
                        
                    ingredients.forEach(ingredient => {
                        if (ingredient.trim()) {
                            const li = document.createElement('li');
                            li.textContent = ingredient.trim();
                            ingredientsList.appendChild(li);
                        }
                    });
                    
                    document.getElementById('modalContent').textContent = data.content;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalTitle').textContent = 'Erreur';
                    document.getElementById('modalContent').textContent = 'Impossible de charger les détails de la recette.';
                });
        }
        
        // Open add/edit recipe modal
        function openEditModal(id = null) {
            const form = document.getElementById('recipeForm');
            form.reset();
            
            if (id) {
                // Edit existing recipe
                document.getElementById('editModalTitle').textContent = 'Modifier la recette';
                currentRecipeId = id;
                
                // Fetch recipe data
                fetch(`/api/recettes/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('recipeId').value = data.id;
                        document.getElementById('recipeName').value = data.name;
                        document.getElementById('recipeCategory').value = data.category_id;
                        
                        // Handle ingredients (converting from array if needed)
                        const ingredients = Array.isArray(data.ingredients) 
                            ? data.ingredients.join('\n') 
                            : data.ingredients;
                        document.getElementById('recipeIngredients').value = ingredients;
                        
                        document.getElementById('recipeContent').value = data.content;
                    })
                    .catch(error => {
                        console.error('Error fetching recipe for edit:', error);
                        closeModals();
                        alert('Erreur lors du chargement de la recette');
                    });
            } else {
                // Add new recipe
                document.getElementById('editModalTitle').textContent = 'Ajouter une recette';
                document.getElementById('recipeId').value = '';
                currentRecipeId = null;
            }
            
            editRecipeModal.style.display = 'block';
        }
        
        // Open confirmation modal for deletion
        function openConfirmModal(id) {
            currentRecipeId = parseInt(id);
            confirmModal.style.display = 'block';
        }
        
        // Close all modals
        function closeModals() {
            recipeModal.style.display = 'none';
            editRecipeModal.style.display = 'none';
            confirmModal.style.display = 'none';
        }
        
        // Delete recipe
        function deleteRecipe(id) {
            fetch(`/api/recettes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la suppression');
                }
                return response.json();
            })
            .then(data => {
                // Remove recipe card from DOM
                const card = document.querySelector(`.recipe-card[data-id="${id}"]`);
                if (card) {
                    card.remove();
                }
                closeModals();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la suppression de la recette');
                closeModals();
            });
        }
        
        // Filter recipes by category
        function filterRecipes(category) {
            const cards = document.querySelectorAll('.recipe-card');
            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Update active filter button
            categoryFilters.forEach(btn => {
                if (btn.dataset.category === category) {
                    btn.classList.add('text-gold', 'border-gold');
                    btn.classList.remove('text-light-gold', 'border-gold/30');
                } else {
                    btn.classList.remove('text-gold', 'border-gold');
                    btn.classList.add('text-light-gold', 'border-gold/30');
                }
            });
        }
        
        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Recipe card click
            recipeGrid.addEventListener('click', (e) => {
                const card = e.target.closest('.recipe-card');
                if (card && !e.target.closest('.edit-btn') && !e.target.closest('.delete-btn')) {
                    openRecipeModal(card.dataset.id);
                }
            });
            
            // Edit button click
            recipeGrid.addEventListener('click', (e) => {
                if (e.target.closest('.edit-btn')) {
                    const card = e.target.closest('.recipe-card');
                    openEditModal(card.dataset.id);
                    e.stopPropagation();
                }
            });
            
            // Delete button click
            recipeGrid.addEventListener('click', (e) => {
                if (e.target.closest('.delete-btn')) {
                    const card = e.target.closest('.recipe-card');
                    openConfirmModal(card.dataset.id);
                    e.stopPropagation();
                }
            });
            
            // Add recipe button
            addRecipeBtn.addEventListener('click', () => {
                openEditModal();
            });
            
            // Category filter buttons
            categoryFilters.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterRecipes(btn.dataset.category);
                });
            });
            
            // Close modals
            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', closeModals);
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === recipeModal || e.target === editRecipeModal || e.target === confirmModal) {
                    closeModals();
                }
            });
            
            // Cancel delete
            document.getElementById('cancelDelete').addEventListener('click', closeModals);
            
            // Confirm delete
            document.getElementById('confirmDelete').addEventListener('click', () => {
                deleteRecipe(currentRecipeId);
            });
            
            // Form submission
            document.getElementById('recipeForm').addEventListener('submit', (e) => {
                e.preventDefault();
                
                const formData = new FormData(e.target);
                const isEditing = formData.get('id');
                const url = isEditing ? `/api/recettes/${formData.get('id')}` : '/api/recettes';
                const method = isEditing ? 'PUT' : 'POST';
                
                // If editing and no new image, remove the image field
                if (isEditing && formData.get('image').size === 0) {
                    formData.delete('image');
                }
                
                fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de l\'enregistrement');
                    }
                    return response.json();
                })
                .then(data => {
                    closeModals();
                    // Reload page to show updated data
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de l\'enregistrement de la recette');
                });
            });
        });
    </script>
</body>
</html>