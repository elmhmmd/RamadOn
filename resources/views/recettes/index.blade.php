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
        .golden-button {
            background: linear-gradient(135deg, #D4B363 0%, #F2D795 50%, #D4B363 100%);
            box-shadow: 0 4px 15px rgba(212, 179, 99, 0.3),
                       0 0 5px rgba(212, 179, 99, 0.5);
            border: 1px solid rgba(212, 179, 99, 0.6);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .golden-button:hover {
            background: linear-gradient(135deg, #E5C785 0%, #F2D795 50%, #E5C785 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(212, 179, 99, 0.4),
                       0 0 10px rgba(212, 179, 99, 0.6);
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
        
        <div class="mb-12">
            <!-- Category and Add Button Container -->
            <div class="flex justify-between items-center flex-wrap gap-4">
                <!-- Category Filter -->
                <div class="flex flex-wrap gap-2">
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
                <button id="addRecipeBtn" class="golden-button px-8 py-3 text-olive rounded-full transition-all flex items-center gap-3 font-semibold tracking-wide">
                    <i class="fas fa-plus text-sm bg-white/20 p-1 rounded-full"></i>
                    <span>Ajouter une recette</span>
                </button>
            </div>
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
                    <a href="{{ route('recettes.show', $recette->id) }}" class="w-full block">
    <button class="voir-recette-btn w-full px-4 py-2 border border-gold/30 rounded-full text-light-gold hover:text-gold hover:border-gold transition-all">
        Voir Recette →
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
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-display text-gold text-3xl gold-glow" id="editModalTitle">Ajouter une recette</h2>
                <button class="close-modal text-gold hover:text-light-gold">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="recipeForm" class="space-y-8">
                @csrf
                <input type="hidden" id="recipeId" name="id">
                
                <!-- Image Upload -->
                <div class="space-y-2">
                    <label class="block text-light-gold">Image de la recette</label>
                    <div class="relative">
                        <input type="file" id="recipeImage" name="image" accept="image/*" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-gold/30 rounded-lg p-8 text-center hover:border-gold/60 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gold mb-2"></i>
                            <p class="text-light-gold">Glissez une image ou cliquez pour sélectionner</p>
                            <p class="text-gold/60 text-sm mt-2" id="selectedFileName">Aucun fichier sélectionné</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="recipeName" class="block text-light-gold mb-2">Titre</label>
                        <input type="text" id="recipeName" name="name" 
                               class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required>
                    </div>
                    <div>
                        <label for="recipeCategory" class="block text-light-gold mb-2">Catégorie</label>
                        <select id="recipeCategory" name="category_id" 
                                class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="recipeContent" class="block text-light-gold mb-2">Contenu de la recette</label>
                    <textarea id="recipeContent" name="content" rows="12" 
                              class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none font-normal" 
                              placeholder="Décrivez votre recette ici..." required></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="golden-button px-8 py-3 text-olive rounded-full transition-all flex items-center gap-2 font-semibold tracking-wide">
                        <i class="fas fa-save"></i>
                        <span>Enregistrer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Replace the existing confirmation modal content with this: -->
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
    
    // Declare currentRecipeId at the top level scope
    let currentRecipeId;

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

            fetch(`/recettes/${recipeId}`)
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

    // Delete Recipe Confirmation and Execution
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // Set the currentRecipeId variable with the recipe's ID
        currentRecipeId = this.closest('.recipe-card').dataset.id;
        confirmModal.style.display = 'block';
    });
});

document.getElementById('confirmDelete').addEventListener('click', function() {
    // Create form data to properly include CSRF token
    const formData = new FormData();
    
    // Using POST directly as specified in your route definition
    fetch(`/recettes/${currentRecipeId}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', [...response.headers.entries()]);
        
        // Clone the response so we can both read the text and still parse as JSON if valid
        return response.text().then(text => {
            console.log('Response text:', text);
            
            if (!response.ok) {
                throw new Error(`Delete failed with status: ${response.status}, message: ${text}`);
            }
            
            try {
                // Try to parse as JSON if possible
                return JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse response as JSON:', e);
                return { success: false, message: 'Invalid response format' };
            }
        });
    })
    .then(data => {
        console.log('Parsed response data:', data);
        const card = document.querySelector(`.recipe-card[data-id="${currentRecipeId}"]`);
        if (card) {
            card.remove();
            confirmModal.style.display = 'none';
            alert('Recette supprimée avec succès');
        } else {
            console.error('Card element not found for ID:', currentRecipeId);
            alert('Recette supprimée, mais rafraîchissement nécessaire');
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        alert('Erreur lors de la suppression de la recette: ' + error.message);
    });
});

    // Edit Recipe
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            // Store the current recipe ID in the same variable
            currentRecipeId = e.target.closest('.recipe-card').dataset.id;

            fetch(`/recettes/${currentRecipeId}`)
                .then(response => response.json())
                .then(data => {
                    // Update modal title
                    document.getElementById('editModalTitle').textContent = 'Modifier la recette';

                    // Fill form with existing data
                    document.getElementById('recipeId').value = data.id;
                    document.getElementById('recipeName').value = data.name;
                    document.getElementById('recipeCategory').value = data.category_id;
                    document.getElementById('recipeContent').value = data.content;

                    // Reset file input display
                    document.getElementById('selectedFileName').textContent = 'Aucun fichier sélectionné';

                    // Show the modal
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
        // Clear currentRecipeId when adding a new recipe
        currentRecipeId = null;
        editRecipeModal.style.display = 'block';
    });

    document.getElementById('recipeForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const recipeId = formData.get('id');

        // Determine if we're editing or creating
        const isEditing = recipeId !== '';
        const url = isEditing ? `/recettes/${recipeId}` : '/recettes';
        const method = isEditing ? 'POST' : 'POST'; // Using POST with _method field for PUT

        // Add _method field for PUT if editing
        if (isEditing) {
            formData.append('_method', 'PUT');
        }

        // Don't send empty file input when editing
        if (isEditing && !formData.get('image').size) {
            formData.delete('image');
        }

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur de sauvegarde');
            return response.json();
        })
        .then(() => {
            // Reload page to show updated data
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'enregistrement de la recette');
        });
    });

    // Handle file input display
    const fileInput = document.getElementById('recipeImage');
    const fileNameDisplay = document.getElementById('selectedFileName');

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = 'Aucun fichier sélectionné';
        }
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