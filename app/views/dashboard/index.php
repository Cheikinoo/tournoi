<div class="max-w-6xl mx-auto px-6 py-8 space-y-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-gray-500 text-sm">Vue d’ensemble de tes tournois</p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
           class="bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-800">
            Nouveau tournoi
        </a>
    </div>

    <!-- EMPTY -->
    <?php if ($totalTournaments === 0): ?>
        <div class="bg-gray-50 border p-6 rounded-xl text-center text-gray-700">
            <p class="font-medium mb-2">Bienvenue</p>
            <p class="text-sm mb-4">Crée ton premier tournoi</p>

            <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
               class="bg-black text-white px-4 py-2 rounded-lg">
                Créer
            </a>
        </div>
    <?php endif; ?>

    <!-- STATS -->
    <div class="grid md:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">Tournois</div>
            <div class="text-3xl font-bold"><?= (int)$totalTournaments ?></div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">Équipes</div>
            <div class="text-3xl font-bold"><?= (int)$totalTeams ?></div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">Matchs</div>
            <div class="text-3xl font-bold"><?= (int)$totalMatches ?></div>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="grid md:grid-cols-3 gap-4">

        <a href="<?= BASE_URL ?>/index.php?url=tournaments"
           class="bg-white border p-5 rounded-xl hover:bg-gray-50 transition">
            <div class="font-semibold">Tournois</div>
            <div class="text-sm text-gray-500">Voir et gérer</div>
        </a>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments"
           class="bg-white border p-5 rounded-xl hover:bg-gray-50 transition">
            <div class="font-semibold">Équipes</div>
            <div class="text-sm text-gray-500">Accéder via tournoi</div>
        </a>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments"
           class="bg-white border p-5 rounded-xl hover:bg-gray-50 transition">
            <div class="font-semibold">Matchs</div>
            <div class="text-sm text-gray-500">Accéder via tournoi</div>
        </a>

    </div>

    <!-- PROGRESSION -->
    <?php
        $progress = 0;
        if ($totalMatches > 0 && isset($playedMatches)) {
            $progress = round(($playedMatches / $totalMatches) * 100);
        }
    ?>

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-3">
            <h2 class="font-semibold">Progression</h2>
            <span class="text-sm text-gray-400"><?= $progress ?>%</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-black h-2 rounded-full"
                 style="width: <?= $progress ?>%"></div>
        </div>

        <p class="mt-2 text-sm text-gray-500">
            <?= $progress ?>% des matchs joués
        </p>

    </div>

    <!-- MATCHS -->
    <?php if (!empty($recentMatches)): ?>

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold">Derniers résultats</h2>

            <a href="<?= BASE_URL ?>/index.php?url=matches"
               class="text-sm text-gray-500 hover:underline">
                Voir tout
            </a>
        </div>

        <div class="space-y-2">

            <?php foreach ($recentMatches as $match): ?>

                <div class="flex justify-between items-center border-b pb-2">

                    <span class="text-sm">
                        <?= e($match['team1_name']) ?>
                        <span class="text-gray-400 mx-1">vs</span>
                        <?= e($match['team2_name']) ?>
                    </span>

                    <span class="font-semibold text-sm">
                        <?= (int)$match['score1'] ?> - <?= (int)$match['score2'] ?>
                    </span>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <?php endif; ?>

    <!-- GUIDE -->
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="font-semibold mb-4">Démarrage rapide</h2>

        <div class="grid md:grid-cols-2 gap-3 text-sm text-gray-600">

            <div>Créer un tournoi</div>
            <div>Ajouter des équipes</div>
            <div>Générer les matchs</div>
            <div>Entrer les scores</div>
            <div>Suivre le classement</div>

        </div>

    </div>

</div>