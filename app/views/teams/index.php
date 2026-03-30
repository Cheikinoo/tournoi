<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Équipes</h1>
        <p class="text-gray-600"><?= e($tournament['name']) ?></p>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 mb-6 max-w-xl">
    <h2 class="text-xl font-bold mb-4">Ajouter une équipe</h2>

    <form method="POST" action="<?= BASE_URL ?>/index.php?url=teams/store" class="flex gap-3">
        <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">
        <input type="text" name="name" placeholder="Nom de l’équipe" class="flex-1 border rounded px-3 py-2" required>
        <button class="bg-gray-900 text-white px-4 py-2 rounded">Ajouter</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left p-4">Nom</th>
                <th class="text-left p-4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teams as $team): ?>
                <tr class="border-t">
                    <td class="p-4"><?= e($team['name']) ?></td>
                    <td class="p-4">
                        <form method="POST" action="<?= BASE_URL ?>/index.php?url=teams/delete" onsubmit="return confirm('Supprimer cette équipe ?')">
                            <input type="hidden" name="id" value="<?= (int) $team['id'] ?>">
                            <input type="hidden" name="tournament_id" value="<?= (int) $tournament['id'] ?>">
                            <button class="bg-red-600 text-white px-3 py-1 rounded">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($teams)): ?>
                <tr>
                    <td colspan="2" class="p-6 text-center text-gray-500">Aucune équipe pour le moment.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>