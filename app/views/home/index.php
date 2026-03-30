<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-6xl mx-auto px-6 py-16">

    <!-- HERO -->
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold mb-4">
            🏆 Gère tes tournois comme un pro
        </h1>

        <p class="text-gray-600 text-lg mb-6">
            Crée, organise et suis tes matchs en temps réel.
        </p>

        <div class="flex justify-center gap-4">

            <a href="<?= BASE_URL ?>/index.php?url=register"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Commencer
            </a>

            <a href="<?= BASE_URL ?>/index.php?url=login"
               class="bg-gray-200 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                Se connecter
            </a>

        </div>
    </div>

    <!-- FEATURES -->
    <div class="grid md:grid-cols-3 gap-6 mb-16">

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <div class="text-3xl mb-2">⚽</div>
            <h3 class="font-bold mb-2">Matchs automatiques</h3>
            <p class="text-gray-500 text-sm">
                Génération intelligente des matchs en un clic.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <div class="text-3xl mb-2">📊</div>
            <h3 class="font-bold mb-2">Classement en direct</h3>
            <p class="text-gray-500 text-sm">
                Résultats et classement mis à jour automatiquement.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <div class="text-3xl mb-2">👥</div>
            <h3 class="font-bold mb-2">Gestion équipes</h3>
            <p class="text-gray-500 text-sm">
                Ajoute facilement équipes et joueurs.
            </p>
        </div>

    </div>

    <!-- CTA -->
    <div class="bg-gray-900 text-white rounded-2xl p-10 text-center">
        <h2 class="text-2xl font-bold mb-3">
            Prêt à lancer ton tournoi ?
        </h2>

        <p class="text-gray-300 mb-6">
            Commence gratuitement et organise ton premier tournoi en quelques minutes.
        </p>

        <a href="<?= BASE_URL ?>/index.php?url=register"
           class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
            Créer un compte
        </a>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>