<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body class="bg-olive min-h-screen">
    <nav class="py-6">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <div class="text-2xl font-display text-gold">RamadOn</div>
            <div class="space-x-8">
                <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-display text-gold text-center mb-12 gold-glow">Nos Recettes du Ramadan</h1>
        
        <!-- Category Filter -->
        <div class="flex justify-center mb-12 space-x-4">
            <button class="px-6 py-2 rounded-full text-gold border border-gold hover:bg-gold hover:text-olive transition-all">
                Toutes les recettes
            </button>
            <button class="px-6 py-2 rounded-full text-light-gold border border-gold/30 hover:border-gold hover:text-gold transition-all">
                Entrées
            </button>
            <button class="px-6 py-2 rounded-full text-light-gold border border-gold/30 hover:border-gold hover:text-gold transition-all">
                Plats
            </button>
            <button class="px-6 py-2 rounded-full text-light-gold border border-gold/30 hover:border-gold hover:text-gold transition-all">
                Desserts
            </button>
        </div>

        <!-- Recipe Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($recettes as $recette)
            <div class="bg-olive border border-gold/30 rounded-lg overflow-hidden hover:border-gold transition-all">
                <img src="{{ $recette->image }}" alt="{{ $recette->name }}" class="w-full h-48 object-cover">
                <div class="p-6">
    {{--<!--<span class="text-light-gold text-sm uppercase tracking-wider">{{ $recette->category->name }}</span>-->--}}
                    <h3 class="font-display text-gold text-xl mt-2 mb-4">{{ $recette->name }}</h3>
                    <p class="text-light-gold text-sm line-clamp-3 mb-6">{{ $recette->content }}</p>
                    <a href="#" class="inline-flex items-center text-gold hover:text-light-gold transition-all">
                        Voir la recette
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025 - Que ce mois soit rempli de bénédictions</p>
    </footer>
</body>
</html>