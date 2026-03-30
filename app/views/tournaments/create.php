<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-2xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">➕ Créer un tournoi</h1>
        <p class="text-gray-500 mt-1">
            Configure ton tournoi en quelques secondes
        </p>
    </div>

    <!-- FORM -->
    <form method="POST"
          action="<?= BASE_URL ?>/index.php?url=tournaments/store"
          class="bg-white rounded-2xl shadow p-6 space-y-5">

        <!-- 🔥 CSRF TOKEN -->
        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

        <!-- NOM -->
        <div>
            <label class="block mb-1 font-medium">Nom du tournoi</label>
            <input type="text"
                   name="name"
                   value="<?= old('name') ?>"
                   placeholder="Ex: Ligue des amis"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-800"
                   required>
        </div>

        <!-- FORMAT -->
        <div>
            <label class="block mb-1 font-medium">Format</label>
            <select name="format"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-800">
                <option value="5v5" <?= old('format') === '5v5' ? 'selected' : '' ?>>⚽ 5 vs 5</option>
                <option value="7v7" <?= old('format') === '7v7' ? 'selected' : '' ?>>⚽ 7 vs 7</option>
                <option value="11v11" <?= old('format') === '11v11' ? 'selected' : '' ?>>⚽ 11 vs 11</option>
            </select>
        </div>

        <!-- TYPE -->
        <div>
            <label class="block mb-1 font-medium">Type de tournoi</label>
            <select name="type"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-800">
                <option value="league" <?= old('type') === 'league' ? 'selected' : '' ?>>🏆 Ligue</option>
                <option value="knockout" <?= old('type') === 'knockout' ? 'selected' : '' ?>>⚔️ Élimination directe</option>
                <option value="groups_knockout" <?= old('type') === 'groups_knockout' ? 'selected' : '' ?>>🔀 Poules + phases finales</option>
            </select>
        </div>

        <!-- STATUS -->
        <div>
            <label class="block mb-1 font-medium">Statut</label>
            <select name="status"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-800">
                <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>📝 Brouillon</option>
                <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>🟢 Actif</option>
                <option value="finished" <?= old('status') === 'finished' ? 'selected' : '' ?>>🏁 Terminé</option>
                <option value="archived" <?= old('status') === 'archived' ? 'selected' : '' ?>>📦 Archivé</option>
            </select>
        </div>

        <!-- DURÉE -->
        <div>
            <label class="block mb-1 font-medium">Durée du match (minutes)</label>
            <input type="number"
                   name="match_duration"
                   value="<?= old('match_duration', 10) ?>"
                   min="1"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-800">
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-between items-center pt-4">

            <a href="<?= BASE_URL ?>/index.php?url=tournaments"
               class="text-gray-500 hover:underline">
                ← Retour
            </a>

            <button class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
                🚀 Créer
            </button>

        </div>

    </form>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>