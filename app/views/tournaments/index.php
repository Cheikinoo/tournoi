<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">🏆 Mes tournois</h1>
        <p class="text-gray-500 text-sm mt-1">
            Gère facilement tous tes tournois
        </p>
    </div>

    <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
        + Nouveau tournoi
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="text-left p-4">Nom</th>
                <th class="text-left p-4">Format</th>
                <th class="text-left p-4">Type</th>
                <th class="text-left p-4">Statut</th>
                <th class="text-left p-4">Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($tournaments as $tournament): ?>

            <?php
                $statusClass = 'bg-gray-100 text-gray-700';

                if ($tournament['status'] === 'active') {
                    $statusClass = 'bg-green-100 text-green-700';
                } elseif ($tournament['status'] === 'draft') {
                    $statusClass = 'bg-yellow-100 text-yellow-700';
                } elseif ($tournament['status'] === 'finished') {
                    $statusClass = 'bg-blue-100 text-blue-700';
                }
            ?>

            <tr class="border-t hover:bg-gray-50 transition">

                <!-- NOM -->
                <td class="p-4 font-semibold">
                    <?= e($tournament['name']) ?>
                </td>

                <!-- FORMAT -->
                <td class="p-4">
                    <?= e($tournament['format']) ?>
                </td>

                <!-- TYPE -->
                <td class="p-4">
                    <?= e($tournament['type']) ?>
                </td>

                <!-- STATUS -->
                <td class="p-4">
                    <span class="px-3 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                        <?= e($tournament['status']) ?>
                    </span>
                </td>

                <!-- ACTIONS -->
                <td class="p-4 flex flex-wrap gap-2">

                    <!-- VOIR -->
                    <a class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition"
                       href="<?= BASE_URL ?>/index.php?url=tournaments/show&id=<?= (int) $tournament['id'] ?>">
                        👁 Voir
                    </a>

                    <!-- MATCHS -->
                    <a class="bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 transition"
                       href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int) $tournament['id'] ?>">
                        ⚽ Matchs
                    </a>

                    <!-- CLASSEMENT -->
                    <a class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition"
                       href="<?= BASE_URL ?>/index.php?url=standings&tournament_id=<?= (int) $tournament['id'] ?>">
                        📊 Classement
                    </a>

                    <!-- EDIT -->
                    <a class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition"
                       href="<?= BASE_URL ?>/index.php?url=tournaments/edit&id=<?= (int) $tournament['id'] ?>">
                        ✏️ Modifier
                    </a>

                    <!-- DELETE -->
                    <form method="POST"
                          action="<?= BASE_URL ?>/index.php?url=tournaments/delete"
                          onsubmit="return confirm('Supprimer ce tournoi ?')">

                        <!-- 🔥 CSRF FIX -->
                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

                        <input type="hidden" name="id" value="<?= (int) $tournament['id'] ?>">

                        <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                            🗑 Supprimer
                        </button>
                    </form>

                </td>

            </tr>

        <?php endforeach; ?>

        <?php if (empty($tournaments)): ?>

            <tr>
                <td colspan="5" class="p-10 text-center text-gray-500">

                    <div class="flex flex-col items-center gap-3">
                        <div class="text-4xl">🏟️</div>
                        <p>Aucun tournoi pour le moment</p>

                        <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
                           class="bg-black text-white px-4 py-2 rounded-lg mt-2">
                            Créer un tournoi
                        </a>
                    </div>

                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</div>