<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-6xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold"><?= e($tournament['name']) ?></h1>
            <p class="text-gray-500">
                Format: <?= e($tournament['format']) ?> |
                Type: <?= e($tournament['type']) ?>
            </p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments"
           class="bg-gray-200 px-4 py-2 rounded">
            ← Retour
        </a>
    </div>

    <!-- AJOUT TEAM -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Ajouter une équipe</h2>

        <form method="POST" action="<?= BASE_URL ?>/index.php?url=teams/store" class="flex gap-3 flex-wrap">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
            <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">

            <input
                type="text"
                name="team_name"
                placeholder="Nom de l’équipe"
                class="border rounded px-4 py-2 flex-1 min-w-[220px]"
                required
            >

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">
                + Ajouter
            </button>
        </form>
    </div>

    <!-- TEAMS -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Équipes</h2>

        <?php if (!empty($teams)): ?>
            <?php foreach ($teams as $team): ?>
                <div class="flex justify-between items-center border-b py-2">
                    <span><?= e($team['name']) ?></span>

                    <form method="POST" action="<?= BASE_URL ?>/index.php?url=teams/delete">
                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= (int) $team['id'] ?>">
                        <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">
                        <button class="text-red-600">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- MATCHS -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Matchs</h2>

        <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/generate">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
            <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">
            <button class="bg-purple-600 text-white px-4 py-2 rounded mb-4">
                Générer les matchs
            </button>
        </form>

        <?php foreach ($matches as $match): ?>

            <div class="border p-4 mb-2 flex justify-between items-center">

                <div>
                    <?= e($match['team1_name']) ?> vs <?= e($match['team2_name']) ?>
                </div>

                <?php if ($match['status'] === 'played'): ?>

                    <div class="font-bold">
                        <?= (int)$match['score1'] ?> - <?= (int)$match['score2'] ?>
                    </div>

                <?php else: ?>

                    <form method="POST" action="<?= BASE_URL ?>/index.php?url=matches/updateScore" class="flex gap-2">

                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">
                        <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">
                        <input type="hidden" name="status" value="played">

                        <input type="number" name="score1" min="0" required class="w-16 border p-1">
                        <input type="number" name="score2" min="0" required class="w-16 border p-1">

                        <button class="bg-green-600 text-white px-2 rounded">OK</button>

                    </form>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>