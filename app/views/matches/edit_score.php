<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold mb-6">⚽ Encoder le score</h1>

    <div class="bg-white rounded-xl shadow p-6">

        <div class="text-xl font-semibold mb-4 text-center">
            <?= e($match['team1_name']) ?> 
            <span class="text-gray-400 mx-2">VS</span> 
            <?= e($match['team2_name']) ?>
        </div>

        <form method="POST"
              action="<?= BASE_URL ?>/index.php?url=matches/updateScore"
              class="space-y-4">

            <!-- 🔥 CSRF -->
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

            <input type="hidden" name="id" value="<?= (int) $match['id'] ?>">

            <!-- TEAM 1 -->
            <div>
                <label class="block mb-1 font-medium">
                    <?= e($match['team1_name']) ?>
                </label>

                <input type="number"
                       name="score1"
                       value="<?= $match['score1'] !== null ? (int)$match['score1'] : 0 ?>"
                       class="w-full border rounded px-3 py-2 text-center text-lg"
                       min="0"
                       required>
            </div>

            <!-- TEAM 2 -->
            <div>
                <label class="block mb-1 font-medium">
                    <?= e($match['team2_name']) ?>
                </label>

                <input type="number"
                       name="score2"
                       value="<?= $match['score2'] !== null ? (int)$match['score2'] : 0 ?>"
                       class="w-full border rounded px-3 py-2 text-center text-lg"
                       min="0"
                       required>
            </div>

            <!-- ACTIONS -->
            <div class="flex justify-between items-center pt-4">

                <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int)$match['tournament_id'] ?>"
                   class="text-gray-500 hover:underline">
                    ← Retour
                </a>

                <button class="bg-gray-900 text-white px-5 py-3 rounded hover:bg-gray-800">
                    💾 Enregistrer
                </button>

            </div>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>