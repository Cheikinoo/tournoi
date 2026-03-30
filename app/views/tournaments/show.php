<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Matchs</h2>

    <!-- GENERATE -->
    <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/generate">
        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
        <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">

        <button class="bg-green-600 text-white px-4 py-2 rounded mb-4">
            🔥 Générer les matchs
        </button>
    </form>

    <?php foreach ($matches as $match): ?>

        <div class="bg-gray-50 rounded-xl p-5 mb-4 flex justify-between items-center">

            <!-- LEFT -->
            <div class="flex-1">

                <!-- TEAMS -->
                <div class="text-lg font-semibold flex justify-between">
                    <span><?= e($match['team1_name']) ?></span>
                    <span class="text-gray-400">VS</span>
                    <span><?= e($match['team2_name']) ?></span>
                </div>

                <!-- ⏰ TIME -->
                <?php if (!empty($match['match_time'])): ?>
                    <div class="text-sm text-gray-400 mt-1">
                        ⏰ <?= date('d/m H:i', strtotime($match['match_time'])) ?>
                    </div>
                <?php endif; ?>

                <!-- SCORE -->
                <div class="text-center text-2xl font-bold mt-2">
                    <?php if ($match['status'] === 'finished'): ?>
                        <?= (int)$match['score1'] ?> - <?= (int)$match['score2'] ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </div>

                <!-- STATUS -->
                <div class="mt-2 text-center">
                    <?php if ($match['status'] === 'finished'): ?>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            ✅ Terminé
                        </span>
                    <?php else: ?>
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                            ⏳ À jouer
                        </span>
                    <?php endif; ?>
                </div>

            </div>

            <!-- RIGHT -->
            <div>

                <?php if ($match['status'] !== 'finished'): ?>

                    <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/updateScore" class="flex gap-2 items-center">

                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">

                        <input type="number" name="score1" min="0" required class="w-16 border p-2 rounded text-center">
                        <span>-</span>
                        <input type="number" name="score2" min="0" required class="w-16 border p-2 rounded text-center">

                        <button class="bg-blue-600 text-white px-3 py-2 rounded">
                            ✔
                        </button>

                    </form>

                <?php endif; ?>

            </div>

        </div>

    <?php endforeach; ?>
</div>