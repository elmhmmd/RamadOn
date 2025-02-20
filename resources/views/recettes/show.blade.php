<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $recette->name }} - RamadOn</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-olive: #2C3315;
            --color-gold: #D4B363;
            --color-light-gold: #E5C785;
        }
        body { font-family: 'Lato', sans-serif; background-color: var(--color-olive); }
        .font-display { font-family: 'Playfair Display', serif; }
        .text-gold { color: var(--color-gold); }
        .text-light-gold { color: var(--color-light-gold); }
        .border-gold { border-color: var(--color-gold); }
        .gold-glow { text-shadow: 0 0 15px rgba(212, 179, 99, 0.4); }
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
<body class="min-h-screen">
    <nav class="py-6">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <a href="/" class="text-2xl font-display text-gold">RamadOn</a>
                <div class="space-x-8">
                    <a href="/recettes" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                    <a href="/temoignages" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="/recettes" class="inline-flex items-center text-light-gold hover:text-gold mb-8 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux recettes
            </a>

            <!-- Recipe Header -->
            <div class="mb-12">
                <span class="text-light-gold text-sm uppercase tracking-wider">{{ $recette->category->name }}</span>
                <h1 class="text-4xl font-display text-gold mt-2 gold-glow">{{ $recette->name }}</h1>
            </div>

            <!-- Recipe Image (if exists) -->
            @if($recette->image)
            <div class="mb-12 rounded-lg overflow-hidden border border-gold/30">
                <img src="{{ asset('storage/images/' . $recette->image) }}" 
                     alt="{{ $recette->name }}" 
                     class="w-full h-auto">
            </div>
            @endif

            <!-- Recipe Content -->
            <div class="prose prose-lg max-w-none">
                <div class="text-light-gold leading-relaxed whitespace-pre-line">
                    {{ $recette->content }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-12">
                <a href="/recettes/{{ $recette->id }}/edit" 
                   class="golden-button px-6 py-2 text-olive rounded-full transition-all flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025 - Que ce mois soit rempli de bénédictions</p>
    </footer>
</body>
</html>
