<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-4xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">⚽ Matchs</h2>

        <!-- GENERER MATCHS -->
        <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/generate">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
            <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

            <button class="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700">
                🔥 Générer les matchs
            </button>
        </form>
    </div>

    <!-- LISTE MATCHS -->
    <div class="space-y-4">

        <?php if (empty($matches)): ?>

            <div class="bg-white p-6 rounded-xl shadow text-center text-gray-500">
                Aucun match généré pour ce tournoi
            </div>

        <?php endif; ?>

        <?php foreach ($matches as $match): ?>

            <?php $isPlayed = ($match['status'] === 'played'); ?>

            <div class="bg-white rounded-2xl shadow p-5 flex items-center justify-between">

                <!-- TEAMS -->
                <div class="flex-1">

                    <div class="flex items-center justify-between text-lg font-semibold">
                        <span><?= e($match['team1_name']) ?></span>
                        <span class="text-gray-400 text-sm">VS</span>
                        <span><?= e($match['team2_name']) ?></span>
                    </div>

                    <!-- SCORE -->
                    <div class="mt-2 text-2xl font-bold text-center">
                        <?php if ($isPlayed): ?>
                            <?= (int)$match['score1'] ?> : <?= (int)$match['score2'] ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>

                    <!-- STATUS -->
                    <div class="mt-2 text-center">
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

                </div>

                <!-- ACTION -->
                <div class="ml-6">

                    <?php if (!$isPlayed): ?>

                        <form method="POST"
                              action="<?= BASE_URL ?>/index.php?url=matches/updateScore"
                              class="flex items-center gap-2">

                            <!-- CSRF -->
                            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                            <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">

                            <input type="number" name="score1" required min="0"
                                class="w-14 text-center border rounded p-1">

                            <span>-</span>

                            <input type="number" name="score2" required min="0"
                                class="w-14 text-center border rounded p-1">

                            <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700">
                                ✔
                            </button>

                        </form>

                    <?php else: ?>

                        <span class="text-gray-400 text-sm">✔ Validé</span>

                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- 🔥 CLASSEMENT LIVE -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4">📊 Classement</h2>

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
                        <td><?= e($team['team_name']) ?></td>
                        <td><?= $team['played'] ?></td>
                        <td><?= $team['points'] ?></td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">
                        Aucun classement disponible
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>