<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ramadan 2025 - Partageons Ensemble')</title>
    
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    
    @vite(['resources/css/app.css'])

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
            <div class="text-2xl font-display text-gold">☪️ Ramadan Kareem</div>
            <div class="space-x-8">
                <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Recettes</a>
                <a href="#" class="nav-link text-light-gold text-lg hover:text-gold">Témoignages</a>
            </div>
        </div>
    </nav>

    
    <main class="container mx-auto px-6 py-24">
        @yield('content')
    </main>

   
    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025 - Que ce mois soit rempli de bénédictions</p>
    </footer>

</body>
</html>
