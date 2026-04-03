<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-5xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center flex-wrap gap-3">

        <div>
            <h2 class="text-2xl font-bold">⚽ Matchs</h2>
            <p class="text-gray-500 text-sm"><?= e($tournament['name']) ?></p>
        </div>

        <?php if (empty($matches)): ?>

            <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/generate">
                <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

                <button class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700 shadow">
                    🔥 Générer les matchs
                </button>
            </form>

        <?php else: ?>

            <span class="text-green-600 text-sm font-semibold">
                ✔ Matchs générés
            </span>

        <?php endif; ?>

    </div>

    <!-- MESSAGE -->
    <?php if (empty($matches)): ?>
        <div class="bg-gray-50 border p-4 rounded-xl text-sm text-gray-700 text-center">
            Génère les matchs pour commencer ⚽
        </div>
    <?php endif; ?>

    <!-- MATCHES -->
    <div class="space-y-4">

        <?php foreach ($matches as $match): ?>

            <?php $isPlayed = ($match['status'] === 'finished'); ?>

            <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">

                <!-- TEAMS (VERSION PRO CENTRÉE) -->
                <div class="flex items-center justify-between">

                    <!-- TEAM 1 -->
                    <div class="flex flex-col items-center gap-2 w-1/3">

                        <img src="/assets/logos/<?= e($match['team1_logo'] ?? 'logo1.png') ?>"
                             class="w-14 h-14 rounded-full border shadow object-contain">

                        <span class="font-semibold text-center">
                            <?= e($match['team1_name']) ?>
                        </span>

                    </div>

                    <!-- SCORE -->
                    <div class="text-4xl font-bold text-center w-1/3">

                        <?php if ($isPlayed): ?>
                            <?= (int)$match['score1'] ?> : <?= (int)$match['score2'] ?>
                        <?php else: ?>
                            <span class="text-gray-300">0 : 0</span>
                        <?php endif; ?>

                    </div>

                    <!-- TEAM 2 -->
                    <div class="flex flex-col items-center gap-2 w-1/3">

                        <img src="/assets/logos/<?= e($match['team2_logo'] ?? 'logo1.png') ?>"
                             class="w-14 h-14 rounded-full border shadow object-contain">

                        <span class="font-semibold text-center">
                            <?= e($match['team2_name']) ?>
                        </span>

                    </div>

                </div>

                <!-- TIME -->
                <?php if (!empty($match['match_time'])): ?>
                    <div class="text-sm text-gray-400 mt-3 text-center">
                        🕒 <?= date('d/m H:i', strtotime($match['match_time'])) ?>
                    </div>
                <?php endif; ?>

                <!-- STATUS -->
                <div class="mt-3 text-center">

                    <?php if ($isPlayed): ?>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            ✔ Terminé
                        </span>
                    <?php else: ?>
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                            ⏳ À jouer
                        </span>
                    <?php endif; ?>

                </div>

                <!-- SCORE FORM -->
                <form method="POST"
                      action="<?= BASE_URL ?>/index.php?url=matches/updateScore"
                      class="mt-5 flex justify-center items-center gap-3">

                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                    <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">

                    <input type="number"
                           name="score1"
                           value="<?= $match['score1'] ?? 0 ?>"
                           min="0"
                           class="w-16 text-center border rounded-lg py-2 text-lg">

                    <span class="text-lg">-</span>

                    <input type="number"
                           name="score2"
                           value="<?= $match['score2'] ?? 0 ?>"
                           min="0"
                           class="w-16 text-center border rounded-lg py-2 text-lg">

                    <button class="<?= $isPlayed ? 'bg-orange-500 hover:bg-orange-600' : 'bg-blue-600 hover:bg-blue-700' ?> text-white px-4 py-2 rounded-lg">
                        <?= $isPlayed ? 'Modifier' : 'Valider' ?>
                    </button>

                </form>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- MINI CLASSEMENT -->
    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">📊 Classement</h2>

            <a href="<?= BASE_URL ?>/index.php?url=standings&tournament_id=<?= (int)$tournament['id'] ?>"
               class="text-sm text-gray-500 hover:underline">
                Voir complet →
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th>#</th>
                    <th>Équipe</th>
                    <th>MJ</th>
                    <th>Pts</th>
                </tr>
            </thead>

            <tbody>

            <?php if (!empty($standings)): ?>

                <?php foreach ($standings as $i => $team): ?>

                    <tr class="border-t">

                        <td><?= $i + 1 ?></td>

                        <td class="flex items-center gap-2">
                            <img src="/assets/logos/<?= e($team['logo'] ?? 'logo1.png') ?>"
                                 class="w-6 h-6 rounded-full border">
                            <?= e($team['team_name']) ?>
                        </td>

                        <td><?= $team['played'] ?></td>

                        <td class="font-bold"><?= $team['points'] ?></td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">
                        Aucun classement
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>