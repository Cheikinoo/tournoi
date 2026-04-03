<div class="max-w-6xl mx-auto px-6 py-16 space-y-24">

    <!-- HERO -->
    <div class="text-center">

        <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
            Organise tes tournois  
            <span class="text-gray-900">simplement</span>
        </h1>

        <p class="text-gray-600 text-lg mb-8 max-w-xl mx-auto">
            Crée, gère et suis tes matchs en temps réel.
            Une solution simple et efficace pour organiser tes compétitions.
        </p>

        <div class="flex justify-center gap-4 flex-wrap">

            <?php if (!Auth::check()): ?>

                <a href="<?= BASE_URL ?>/index.php?url=register"
                   class="bg-black text-white px-6 py-3 rounded-xl hover:bg-gray-800 transition font-semibold shadow">
                    Commencer gratuitement
                </a>

                <a href="<?= BASE_URL ?>/index.php?url=login"
                   class="bg-gray-100 px-6 py-3 rounded-xl hover:bg-gray-200 transition">
                    Se connecter
                </a>

            <?php else: ?>

                <a href="<?= BASE_URL ?>/index.php?url=dashboard"
                   class="bg-black text-white px-6 py-3 rounded-xl hover:bg-gray-800 transition font-semibold shadow">
                    Accéder au dashboard
                </a>

            <?php endif; ?>

        </div>

    </div>

    <!-- TRUST -->
    <div class="text-center">
        <p class="text-gray-400 text-sm">
            Utilisé pour organiser des tournois amateurs et locaux
        </p>
    </div>

    <!-- FEATURES -->
    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition text-center">
            <h3 class="font-semibold text-lg mb-2">Rapide</h3>
            <p class="text-gray-500 text-sm">
                Crée un tournoi et génère les matchs en quelques secondes.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition text-center">
            <h3 class="font-semibold text-lg mb-2">Classement automatique</h3>
            <p class="text-gray-500 text-sm">
                Les scores mettent à jour automatiquement le classement.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition text-center">
            <h3 class="font-semibold text-lg mb-2">Simple</h3>
            <p class="text-gray-500 text-sm">
                Interface claire, pensée pour aller à l’essentiel.
            </p>
        </div>

    </div>

    <!-- HOW IT WORKS -->
    <div class="text-center">

        <h2 class="text-2xl font-semibold mb-8">Comment ça marche</h2>

        <div class="flex flex-col md:flex-row justify-center gap-8 text-sm text-gray-600">

            <div>Créer un tournoi</div>
            <div>Ajouter les équipes</div>
            <div>Générer les matchs</div>
            <div>Entrer les scores</div>

        </div>

    </div>

    <!-- CTA -->
    <div class="bg-gray-900 text-white rounded-2xl p-12 text-center">

        <h2 class="text-3xl font-bold mb-4">
            Lance ton tournoi maintenant
        </h2>

        <p class="text-gray-300 mb-8 max-w-md mx-auto">
            Aucune installation, tout fonctionne directement en ligne.
        </p>

        <?php if (!Auth::check()): ?>

            <a href="<?= BASE_URL ?>/index.php?url=register"
               class="bg-white text-black px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition shadow">
                Créer un compte
            </a>

        <?php else: ?>

            <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
               class="bg-white text-black px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition shadow">
                Nouveau tournoi
            </a>

        <?php endif; ?>

    </div>

</div>