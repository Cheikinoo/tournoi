<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php if (!isset($tournament)) die('Accès interdit'); ?>

<div class="max-w-6xl mx-auto px-6 py-8 space-y-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center flex-wrap gap-3">

        <div>
            <h1 class="text-3xl font-bold"><?= e($tournament['name']) ?></h1>
            <p class="text-gray-500 text-sm mt-1">
                <?= e($tournament['format']) ?> • <?= e($tournament['type']) ?>
            </p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments"
           class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            ← Retour
        </a>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-3 gap-4">

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-400 text-sm">Équipes</p>
            <p class="text-2xl font-bold"><?= count($teams) ?></p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-400 text-sm">Matchs</p>
            <p class="text-2xl font-bold"><?= count($matches) ?></p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-400 text-sm">Progression</p>
            <?php
                $played = count(array_filter($matches, fn($m) => $m['status'] === 'finished'));
                $progress = count($matches) > 0 ? round(($played / count($matches)) * 100) : 0;
            ?>
            <p class="text-2xl font-bold"><?= $progress ?>%</p>
        </div>

    </div>

    <!-- PROGRESS BAR -->
    <div class="bg-gray-200 rounded-full h-3 overflow-hidden">
        <div class="bg-green-600 h-full transition-all"
             style="width: <?= $progress ?>%"></div>
    </div>

    <!-- ACTIONS -->
    <div class="flex gap-3 flex-wrap">

        <a href="<?= BASE_URL ?>/index.php?url=teams&tournament_id=<?= (int)$tournament['id'] ?>"
           class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
            👥 Équipes
        </a>

        <?php if (count($teams) >= 2): ?>

            <?php if (empty($matches)): ?>

                <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/generate">
                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                    <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

                    <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 shadow">
                        🔥 Générer les matchs
                    </button>
                </form>

            <?php else: ?>

                <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int)$tournament['id'] ?>"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    ⚽ Voir les matchs
                </a>

                <!-- RESET (optionnel déjà prêt backend) -->
                <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/clear"
                      onsubmit="return confirm('Supprimer tous les matchs ?')">

                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                    <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        🗑 Reset
                    </button>
                </form>

            <?php endif; ?>

        <?php else: ?>

            <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg">
                Min 2 équipes
            </button>

        <?php endif; ?>

        <?php if (!empty($matches)): ?>
            <a href="<?= BASE_URL ?>/index.php?url=standings&tournament_id=<?= (int)$tournament['id'] ?>"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                📊 Classement
            </a>
        <?php endif; ?>

    </div>

    <!-- GRID -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- ADD TEAM -->
        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-lg font-semibold mb-4">Ajouter une équipe</h2>

            <form method="POST"
                  action="<?= BASE_URL ?>/index.php?url=teams/store"
                  class="space-y-4">

                <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

                <input type="text"
                       name="team_name"
                       placeholder="Nom de l'équipe"
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-gray-900"
                       required>

                <!-- LOGOS -->
                <div class="grid grid-cols-5 gap-3 justify-items-center">

                    <?php for ($i = 1; $i <= 20; $i++): ?>
                        <label class="cursor-pointer group">
                            <input type="radio"
                                   name="logo"
                                   value="logo<?= $i ?>.png"
                                   class="hidden peer"
                                   <?= $i === 1 ? 'checked' : '' ?>>

                            <img src="<?= BASE_URL ?>/assets/logos/logo<?= $i ?>.png"
                                 class="w-12 h-12 object-contain rounded-lg border
                                        peer-checked:border-black
                                        peer-checked:scale-110
                                        group-hover:scale-105 transition">
                        </label>
                    <?php endfor; ?>

                </div>

                <button class="bg-black text-white px-5 py-2 rounded-lg w-full hover:bg-gray-800">
                    Ajouter
                </button>

            </form>

        </div>

        <!-- TEAMS -->
        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between mb-4">
                <h2 class="text-lg font-semibold">Équipes</h2>
                <span class="text-gray-400"><?= count($teams) ?></span>
            </div>

            <?php if (empty($teams)): ?>

                <p class="text-center text-gray-400 py-10">Aucune équipe</p>

            <?php else: ?>

                <div class="grid grid-cols-2 gap-3">

                    <?php foreach ($teams as $team): ?>

                        <div class="bg-gray-50 p-3 rounded-xl flex items-center gap-3 hover:shadow transition">

                            <img src="<?= BASE_URL ?>/assets/logos/<?= e($team['logo'] ?? 'logo1.png') ?>"
                                 class="w-10 h-10 rounded-full border">

                            <span class="font-medium"><?= e($team['name']) ?></span>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>