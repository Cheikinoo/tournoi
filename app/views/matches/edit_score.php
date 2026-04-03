<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-xl mx-auto px-6 py-10 space-y-6">

    <!-- HEADER -->
    <div class="text-center">
        <h1 class="text-2xl font-bold">Résultat du match</h1>
        <p class="text-gray-500 text-sm mt-1">
            <?= e($match['team1_name']) ?> vs <?= e($match['team2_name']) ?>
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        <!-- TEAMS -->
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                <img src="<?= BASE_URL ?>/assets/logos/<?= e($match['team1_logo'] ?? 'logo1.png') ?>"
                     class="w-10 h-10 rounded-full border object-contain">

                <span class="font-semibold">
                    <?= e($match['team1_name']) ?>
                </span>

            </div>

            <span class="text-gray-400 text-sm">VS</span>

            <div class="flex items-center gap-3">

                <span class="font-semibold">
                    <?= e($match['team2_name']) ?>
                </span>

                <img src="<?= BASE_URL ?>/assets/logos/<?= e($match['team2_logo'] ?? 'logo1.png') ?>"
                     class="w-10 h-10 rounded-full border object-contain">

            </div>

        </div>

        <!-- FORM -->
        <form method="POST"
              action="<?= BASE_URL ?>/index.php?url=matches/updateScore"
              class="space-y-6">

            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
            <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">

            <!-- SCORE -->
            <div class="flex items-center justify-center gap-4">

                <input type="number"
                       name="score1"
                       value="<?= $match['score1'] !== null ? (int)$match['score1'] : 0 ?>"
                       min="0"
                       class="w-20 h-20 text-center text-3xl font-bold border rounded-xl focus:ring-2 focus:ring-gray-900"
                       required>

                <span class="text-3xl font-bold text-gray-400">:</span>

                <input type="number"
                       name="score2"
                       value="<?= $match['score2'] !== null ? (int)$match['score2'] : 0 ?>"
                       min="0"
                       class="w-20 h-20 text-center text-3xl font-bold border rounded-xl focus:ring-2 focus:ring-gray-900"
                       required>

            </div>

            <!-- PRESETS -->
            <div class="flex justify-center gap-2 flex-wrap">

                <button type="button" onclick="setScore(0,0)" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">0-0</button>
                <button type="button" onclick="setScore(1,0)" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">1-0</button>
                <button type="button" onclick="setScore(2,1)" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">2-1</button>
                <button type="button" onclick="setScore(3,2)" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">3-2</button>

            </div>

            <!-- ACTIONS -->
            <div class="flex justify-between items-center pt-4">

                <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int)$match['tournament_id'] ?>"
                   class="text-gray-500 hover:underline">
                    Retour
                </a>

                <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                    Enregistrer
                </button>

            </div>

        </form>

    </div>

</div>

<script>

function setScore(s1, s2) {
    document.querySelector('input[name="score1"]').value = s1;
    document.querySelector('input[name="score2"]').value = s2;
}

</script>