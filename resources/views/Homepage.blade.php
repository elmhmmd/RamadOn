<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramadan 2025 - Partageons Ensemble</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/styles.css'])
</head>
<body class="bg-olive min-h-screen">
    <nav class="py-6">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-display text-gold">
                    RamadOn
                </div>
                <div class="space-x-8">
                    <a href="{{ route('recettes.index') }}" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                    <a href="{{ route('temoignages.index') }}" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="py-32">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-6xl font-display text-gold mb-6 gold-glow">Ramadan Moubarak 2025</h1>
            <p class="text-2xl text-light-gold mb-12">Partageons la magie du mois sacré ensemble</p>
            <div class="space-x-6">
                <a href="{{ route('recettes.index') }}" 
                   class="inline-block border-2 border-gold text-light-gold px-8 py-4 rounded-lg font-display hover:bg-gold hover:text-olive transition duration-300">
                    Découvrir les Recettes
                </a>
                <a href="{{ route('temoignages.index') }}" 
                   class="inline-block bg-gold text-light-gold px-8 py-4 rounded-lg font-display hover:bg-gold/90 transition duration-300">
                    Voir les Témoignages
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-24">
        <div class="grid md:grid-cols-2 gap-16">
            <div class="border border-gold/30 rounded-lg p-10 hover:border-gold/60 transition duration-300">
                <div class="text-4xl text-gold mb-6 text-center">
                    <i class="fas fa-moon"></i>
                </div>
                <h2 class="text-3xl font-display text-gold mb-6 text-center">Recettes Iftar et Suhoor</h2>
                <p class="text-light-gold text-lg mb-8 leading-relaxed">
                    Explorez notre collection de délicieuses recettes traditionnelles, 
                    soigneusement sélectionnées pour vos repas d'Iftar et Suhoor.
                </p>
                <div class="text-center">
                    <a href="{{ route('recettes.index') }}" 
                       class="inline-block text-light-gold hover:text-gold transition duration-300 text-lg">
                        Explorer les recettes →
                    </a>
                </div>
            </div>

            <div class="border border-gold/30 rounded-lg p-10 hover:border-gold/60 transition duration-300">
                <div class="text-4xl text-gold mb-6 text-center">
                    <i class="fas fa-star-and-crescent"></i>
                </div>
                <h2 class="text-3xl font-display text-gold mb-6 text-center">Témoignages et Expériences</h2>
                <p class="text-light-gold text-lg mb-8 leading-relaxed">
                    Découvrez les expériences inspirantes de notre communauté 
                    et partagez vos propres moments de spiritualité.
                </p>
                <div class="text-center">
                    <a href="{{ route('temoignages.index') }}" 
                       class="inline-block text-light-gold hover:text-gold transition duration-300 text-lg">
                        Lire les témoignages →
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-24 border border-gold/30 rounded-lg p-12">
            <h2 class="text-3xl font-display text-gold mb-12 text-center">Notre Communauté en Chiffres</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="text-center">
                    <p class="text-6xl font-display text-gold mb-4">{{ $recettesCount }}</p>
                    <p class="text-xl text-light-gold">Recettes Partagées</p>
                </div>
                <div class="text-center">
                    <p class="text-6xl font-display text-gold mb-4">{{ $temoignagesCount }}</p>
                    <p class="text-xl text-light-gold">Témoignages Publiés</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-display text-gold mb-4">{{ $popularRecette }}</p>
                    <p class="text-xl text-light-gold">Recette la Plus Populaire</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-display text-gold mb-4">{{ $popularTemoignage }}</p>
                    <p class="text-xl text-light-gold">Témoignage le Plus Populaire</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-gold/30">
        <div class="container mx-auto px-6 text-center">
            <p class="text-light-gold">Ramadan Kareem 2025 - Que ce mois soit rempli de bénédictions</p>
        </div>
    </footer>
</body>
</html>