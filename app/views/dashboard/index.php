<div class="max-w-6xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">📊 Dashboard</h1>
            <p class="text-gray-500">Gère tes tournois facilement</p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
           class="bg-black text-white px-5 py-3 rounded-lg hover:opacity-90">
            ➕ Nouveau tournoi
        </a>
    </div>

    <!-- STATS -->
    <div class="grid md:grid-cols-3 gap-4 mb-8">

        <div class="bg-white rounded-2xl shadow p-5">
            <div class="text-sm text-gray-500">🏆 Tournois</div>
            <div class="text-3xl font-bold"><?= (int) $totalTournaments ?></div>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <div class="text-sm text-gray-500">👥 Équipes</div>
            <div class="text-3xl font-bold"><?= (int) $totalTeams ?></div>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <div class="text-sm text-gray-500">⚽ Matchs</div>
            <div class="text-3xl font-bold"><?= (int) $totalMatches ?></div>
        </div>

    </div>

    <!-- ACTIONS RAPIDES -->
    <div class="grid md:grid-cols-3 gap-4 mb-8">

        <a href="<?= BASE_URL ?>/index.php?url=tournaments"
           class="bg-blue-600 text-white p-5 rounded-2xl hover:opacity-90 transition">
            <div class="text-lg font-semibold">🏆 Tournois</div>
            <div class="text-sm opacity-80">Voir et gérer</div>
        </a>

        <a href="<?= BASE_URL ?>/index.php?url=teams"
           class="bg-green-600 text-white p-5 rounded-2xl hover:opacity-90 transition">
            <div class="text-lg font-semibold">👥 Équipes</div>
            <div class="text-sm opacity-80">Ajouter / modifier</div>
        </a>

        <a href="<?= BASE_URL ?>/index.php?url=matches"
           class="bg-purple-600 text-white p-5 rounded-2xl hover:opacity-90 transition">
            <div class="text-lg font-semibold">⚽ Matchs</div>
            <div class="text-sm opacity-80">Scores & planning</div>
        </a>

    </div>

    <!-- PROGRESSION (🔥 NOUVEAU) -->
    <?php
        $progress = 0;
        if ($totalMatches > 0 && isset($playedMatches)) {
            $progress = round(($playedMatches / $totalMatches) * 100);
        }
    ?>

    <div class="bg-white rounded-2xl shadow p-6 mb-8">

        <h2 class="text-xl font-semibold mb-4">📈 Progression des matchs</h2>

        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div class="bg-green-500 h-4 rounded-full transition-all duration-500"
                 style="width: <?= $progress ?>%"></div>
        </div>

        <div class="mt-2 text-sm text-gray-500">
            <?= $progress ?>% des matchs joués
        </div>

    </div>

    <!-- DERNIERS MATCHS (🔥 NOUVEAU) -->
    <?php if (!empty($recentMatches)): ?>

    <div class="bg-white rounded-2xl shadow p-6 mb-8">

        <h2 class="text-xl font-semibold mb-4">🕒 Derniers résultats</h2>

        <div class="space-y-2">

            <?php foreach ($recentMatches as $match): ?>

                <div class="flex justify-between border-b pb-2">

                    <span>
                        <?= e($match['team1_name']) ?>
                        <span class="text-gray-400 mx-1">vs</span>
                        <?= e($match['team2_name']) ?>
                    </span>

                    <span class="font-semibold">
                        <?= (int)$match['score1'] ?> - <?= (int)$match['score2'] ?>
                    </span>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <?php endif; ?>

    <!-- GUIDE -->
    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-xl font-semibold mb-4">🚀 Comment commencer ?</h2>

        <ol class="space-y-2 text-gray-600 list-decimal list-inside">
            <li>Créer un tournoi</li>
            <li>Ajouter des équipes</li>
            <li>Générer les matchs</li>
            <li>Encoder les scores</li>
            <li>Consulter le classement</li>
        </ol>

    </div>

</div>