<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-5xl mx-auto px-6 py-8 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center flex-wrap gap-3">
        <div>
            <h1 class="text-3xl font-bold">Équipes</h1>
            <p class="text-gray-500 text-sm"><?= e($tournament['name']) ?></p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments/show&id=<?= (int)$tournament['id'] ?>"
           class="text-gray-500 hover:underline">
            ← Retour
        </a>
    </div>

    <!-- INFO -->
    <div class="bg-gray-50 border p-4 rounded-xl text-sm text-gray-700">
        Ajoute au moins <strong>2 équipes</strong> pour générer les matchs
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
                <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">

                <!-- 🔥 FIX ICI -->
                <input type="text"
                       name="team_name"
                       placeholder="Nom de l’équipe"
                       required
                       minlength="2"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">

                <!-- LOGOS -->
                <div class="grid grid-cols-5 gap-3 justify-items-center">

                    <?php for ($i = 1; $i <= 20; $i++): ?>

                        <label class="cursor-pointer group">
                            <input type="radio"
                                   name="logo"
                                   value="logo<?= $i ?>.png"
                                   class="hidden peer"
                                   <?= $i === 1 ? 'checked' : '' ?>>

                            <img src="/assets/logos/logo<?= $i ?>.png"
                                 class="w-10 h-10 object-contain rounded-lg border
                                        peer-checked:border-green-600
                                        peer-checked:ring-2
                                        peer-checked:ring-green-300
                                        peer-checked:scale-110
                                        group-hover:scale-105 transition">
                        </label>

                    <?php endfor; ?>

                </div>

                <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 w-full">
                    Ajouter
                </button>

            </form>

        </div>

        <!-- LIST -->
        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Liste</h2>

                <span class="text-sm text-gray-400">
                    <?= count($teams) ?>
                </span>
            </div>

            <?php if (empty($teams)): ?>

                <div class="text-center text-gray-500 py-10">
                    <p>Aucune équipe</p>
                </div>

            <?php else: ?>

                <div class="space-y-2">

                    <?php foreach ($teams as $team): ?>

                        <div class="bg-gray-50 p-3 rounded-lg flex items-center justify-between">

                            <div class="flex items-center gap-3">

                                <img src="/assets/logos/<?= e($team['logo'] ?? 'logo1.png') ?>"
                                     class="w-8 h-8 rounded-full object-contain border">

                                <span class="font-medium">
                                    <?= e($team['name']) ?>
                                </span>

                            </div>

                            <form method="POST"
                                  action="<?= BASE_URL ?>/index.php?url=teams/delete"
                                  onsubmit="return confirm('Supprimer cette équipe ?')">

                                <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                                <input type="hidden" name="id" value="<?= (int) $team['id'] ?>">
                                <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">

                                <button class="text-red-500 text-sm hover:underline">
                                    Supprimer
                                </button>

                            </form>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

    <!-- NEXT STEP -->
    <div class="flex justify-end pt-4">

        <?php if (count($teams) >= 2): ?>

            <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int)$tournament['id'] ?>"
               class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700">
                Continuer vers les matchs →
            </a>

        <?php else: ?>

            <button disabled
                class="bg-gray-300 text-gray-500 px-5 py-3 rounded-lg cursor-not-allowed">
                Minimum 2 équipes
            </button>

        <?php endif; ?>

    </div>

</div>