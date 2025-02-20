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
        .category-filter {
            cursor: pointer;
        }
        .category-filter.active {
            background-color: var(--color-gold);
            color: var(--color-olive);
        }
        .recipe-card {
            display: block;
            transition: opacity 0.2s;
        }
        .recipe-card.hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-olive min-h-screen">
    <nav class="py-6">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-display text-gold">RamadOn</div>
                <div class="space-x-8">
                    <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                    <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-display text-gold text-center mb-12 gold-glow">Nos Recettes du Ramadan</h1>
        
        <div class="flex flex-col items-center mb-12">
            <!-- Category Filter -->
            <div class="flex justify-center mb-6 space-x-4 flex-wrap">
                <button type="button" class="category-filter active px-6 py-2 rounded-full border" data-category="all">
                    Toutes les recettes
                </button>
                @foreach($categories as $category)
                <button type="button" class="category-filter px-6 py-2 rounded-full border" data-category="{{ $category->name }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>

            <!-- Add Recipe Button -->
            <button id="addRecipeBtn" class="px-6 py-2 bg-gold text-olive rounded-full hover:bg-light-gold transition-all flex items-center">
                <i class="fas fa-plus mr-2"></i> Ajouter une recette
            </button>
        </div>
        
        <!-- Recipe Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="recipeGrid">
            @foreach($recettes as $recette)
            <div class="recipe-card bg-olive border border-gold/30 rounded-lg overflow-hidden hover:border-gold transition-all" 
                 data-category="{{ $recette->category->name }}" 
                 data-id="{{ $recette->id }}">
                <div class="p-6">
                    <span class="text-light-gold text-sm uppercase tracking-wider">{{ $recette->category->name }}</span>
                    <h3 class="font-display text-gold text-xl mt-2 mb-4">{{ $recette->name }}</h3>
                    
                    <div class="flex flex-col space-y-4">
                        <button class="voir-recette-btn w-full px-4 py-2 border border-gold/30 rounded-full text-light-gold hover:text-gold hover:border-gold transition-all">
                            Voir Recette →
                        </button>
                        
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
            <div class="mb-8">
                <h3 class="text-gold font-display text-xl mb-3">Ingrédients</h3>
                <ul id="modalIngredients" class="text-light-gold list-disc pl-5 space-y-2">
                </ul>
            </div>
            <div>
                <h3 class="text-gold font-display text-xl mb-3">Préparation</h3>
                <p id="modalContent" class="text-light-gold leading-relaxed">
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
                    <label for="recipeIngredients" class="block text-light-gold mb-2">Ingrédients (un par ligne)</label>
                    <textarea id="recipeIngredients" name="ingredients" rows="5" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required></textarea>
                </div>
                <div>
                    <label for="recipeContent" class="block text-light-gold mb-2">Instructions</label>
                    <textarea id="recipeContent" name="content" rows="8" class="w-full p-2 rounded bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-gold text-olive rounded hover:bg-light-gold transition-all">
                        Enregistrer
                    </button>
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
                <button id="cancelDelete" class="px-4 py-2 border border-gold/50 text-gold rounded hover:border-gold transition-all">
                    Annuler
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-all">
                    Supprimer
                </button>
            </div>
        </div>
    </div>

    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025 - Que ce mois soit rempli de bénédictions</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recipeGrid = document.getElementById('recipeGrid');
            const recipeModal = document.getElementById('recipeModal');
            const editRecipeModal = document.getElementById('editRecipeModal');
            const confirmModal = document.getElementById('confirmModal');
            const categoryFilters = document.querySelectorAll('.category-filter');
            const addRecipeBtn = document.getElementById('addRecipeBtn');
            let currentRecipeId = null;

            // CSRF token setup
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Filter functionality
            function filterRecipes(selectedCategory) {
                // Reset all buttons to inactive state
                document.querySelectorAll('.category-filter').forEach(btn => {
                    btn.classList.remove('active', 'bg-gold', 'text-olive');
                    btn.classList.add('text-light-gold');
                });

                // Activate only the clicked button
                const activeButton = document.querySelector(`.category-filter[data-category="${selectedCategory}"]`);
                if (activeButton) {
                    activeButton.classList.add('active', 'bg-gold', 'text-olive');
                    activeButton.classList.remove('text-light-gold');
                }

                // Show/hide recipes
                document.querySelectorAll('.recipe-card').forEach(recipe => {
                    if (selectedCategory === 'all' || recipe.dataset.category === selectedCategory) {
                        recipe.classList.remove('hidden');
                    } else {
                        recipe.classList.add('hidden');
                    }
                });
            }

            // Add click handlers to filter buttons
            document.querySelectorAll('.category-filter').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const category = e.currentTarget.dataset.category;
                    filterRecipes(category);
                });
            });

            // Initialize with all recipes showing
            filterRecipes('all');

            // View Recipe
            document.querySelectorAll('.voir-recette-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const recipeId = e.target.closest('.recipe-card').dataset.id;
                    
                    fetch(`/api/recettes/${recipeId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modalTitle').textContent = data.name;
                            document.getElementById('modalCategory').textContent = data.category.name;
                            
                            const ingredientsList = document.getElementById('modalIngredients');
                            ingredientsList.innerHTML = '';
                            data.ingredients.split('\n').forEach(ingredient => {
                                if (ingredient.trim()) {
                                    const li = document.createElement('li');
                                    li.textContent = ingredient.trim();
                                    ingredientsList.appendChild(li);
                                }
                            });
                            
                            document.getElementById('modalContent').textContent = data.content;
                            recipeModal.style.display = 'block';
                        });
                });
            });

            // Delete Recipe
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    currentRecipeId = e.target.closest('.recipe-card').dataset.id;
                    confirmModal.style.display = 'block';
                });
            });

            // Confirm Delete
            document.getElementById('confirmDelete').addEventListener('click', () => {
                fetch(`/api/recettes/${currentRecipeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur de suppression');
                    return response.json();
                })
                .then(() => {
                    const card = document.querySelector(`.recipe-card[data-id="${currentRecipeId}"]`);
                    if (card) card.remove();
                    confirmModal.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la suppression de la recette');
                });
            });

            // Edit Recipe
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const recipeId = e.target.closest('.recipe-card').dataset.id;
                    
                    fetch(`/api/recettes/${recipeId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editModalTitle').textContent = 'Modifier la recette';
                            document.getElementById('recipeId').value = data.id;
                            document.getElementById('recipeName').value = data.name;
                            document.getElementById('recipeCategory').value = data.category_id;
                            document.getElementById('recipeIngredients').value = data.ingredients;
                            document.getElementById('recipeContent').value = data.content;
                            editRecipeModal.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Erreur lors du chargement de la recette');
                        });
                });
            });

            // Add Recipe
            addRecipeBtn.addEventListener('click', () => {
                document.getElementById('editModalTitle').textContent = 'Ajouter une recette';
                document.getElementById('recipeForm').reset();
                document.getElementById('recipeId').value = '';
                editRecipeModal.style.display = 'block';
            });

            // Form Submit (Add/Edit)
            document.getElementById('recipeForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const isEditing = formData.get('id');
                const url = isEditing ? `/api/recettes/${formData.get('id')}` : '/api/recettes';
                const method = isEditing ? 'PUT' : 'POST';

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur lors de l\'enregistrement');
                    return response.json();
                })
                .then(() => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de l\'enregistrement de la recette');
                });
            });

            // Close Modals
            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', () => {
                    recipeModal.style.display = 'none';
                    editRecipeModal.style.display = 'none';
                    confirmModal.style.display = 'none';
                });
            });

            document.getElementById('cancelDelete').addEventListener('click', () => {
                confirmModal.style.display = 'none';
            });

            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === recipeModal || e.target === editRecipeModal || e.target === confirmModal) {
                    recipeModal.style.display = 'none';
                    editRecipeModal.style.display = 'none';
                    confirmModal.style.display = 'none';
                }
            });

            // Initialize with "all" filter active
            filterRecipes('all');
        });
    </script>
</body>
</html>