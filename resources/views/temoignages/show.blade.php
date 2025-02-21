<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $temoignage->title }} - RamadOn</title>
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
        .golden-button { background: linear-gradient(135deg, #D4B363 0%, #F2D795 50%, #D4B363 100%); box-shadow: 0 4px 15px rgba(212, 179, 99, 0.3); border: 1px solid rgba(212, 179, 99, 0.6); text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); }
        .golden-button:hover { background: linear-gradient(135deg, #E5C785 0%, #F2D795 50%, #E5C785 100%); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(212, 179, 99, 0.4); }
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
            <a href="/temoignages" class="inline-flex items-center text-light-gold hover:text-gold mb-8 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux témoignages
            </a>

            <div class="mb-12">
                <span class="text-light-gold text-sm uppercase tracking-wider">{{ $temoignage->auteur }}</span>
                <h1 class="text-4xl font-display text-gold mt-2 gold-glow">{{ $temoignage->title }}</h1>
            </div>

            @if($temoignage->image)
            <div class="mb-12 rounded-lg overflow-hidden border border-gold/30">
                <img src="{{ asset('storage/' . $temoignage->image) }}" alt="{{ $temoignage->title }}" class="w-full h-auto">
            </div>
            @endif

            <div class="max-w-3xl mx-auto text-light-gold leading-relaxed break-words whitespace-pre-wrap">
    {{ $temoignage->content }}
</div>



            <div class="mt-16">
                <h2 class="text-2xl font-display text-gold mb-6">Commentaires</h2>
                @if(session('success'))
                    <div class="bg-green-500/20 border border-green-500 text-light-gold p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                @if($temoignage->comments->isEmpty())
                    <p class="text-light-gold">Aucun commentaire pour le moment.</p>
                @else
                    <div class="space-y-6">
                        @foreach($temoignage->comments as $comment)
                            <div class="border border-gold/30 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-light-gold font-semibold">{{ $comment->auteur }}</span>
                                    <span class="text-light-gold text-sm">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="text-light-gold">{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('temoignages.comments.store', $temoignage->id) }}" method="POST" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label for="auteur" class="block text-light-gold mb-2">Votre nom</label>
                        <input type="text" id="auteur" name="auteur" class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" placeholder="Entrez votre nom" required>
                    </div>
                    <div>
                        <label for="content" class="block text-light-gold mb-2">Votre commentaire</label>
                        <textarea id="content" name="content" rows="4" class="w-full p-3 rounded-lg bg-olive border border-gold/50 text-gold focus:border-gold focus:outline-none" placeholder="Écrivez votre commentaire ici..." required></textarea>
                    </div>
                    <button type="submit" class="golden-button px-6 py-2 text-olive rounded-full transition-all flex items-center gap-2">
                        <i class="fas fa-comment"></i>
                        <span>Publier</span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-gold/30 text-center">
        <p class="text-light-gold">Ramadan Kareem 2025</p>
    </footer>
</body>
</html>