<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-2xl mx-auto px-6 py-8 space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold">Créer un tournoi</h1>
        <p class="text-gray-500 mt-1">
            Configure ton tournoi en quelques secondes
        </p>
    </div>

    <!-- ONBOARDING -->
    <div class="bg-gray-50 border p-4 rounded-xl text-sm text-gray-700">
        <strong>Étapes :</strong>
        <ul class="mt-2 list-disc list-inside">
            <li>Ajouter des équipes</li>
            <li>Générer les matchs</li>
            <li>Entrer les scores</li>
            <li>Consulter le classement</li>
        </ul>
    </div>

    <!-- FORM -->
    <form method="POST"
          action="<?= BASE_URL ?>/index.php?url=tournaments/store"
          class="bg-white rounded-2xl shadow p-6 space-y-6">

        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

        <!-- NOM -->
        <div>
            <label class="block mb-1 font-medium">Nom</label>
            <input type="text"
                   name="name"
                   value="<?= old('name') ?>"
                   placeholder="Ex: Ligue des amis"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900"
                   required>
        </div>

        <!-- FORMAT -->
        <div>
            <label class="block mb-1 font-medium">Format</label>
            <select name="format"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
                <option value="5v5" <?= old('format', '5v5') === '5v5' ? 'selected' : '' ?>>5 vs 5</option>
                <option value="7v7" <?= old('format') === '7v7' ? 'selected' : '' ?>>7 vs 7</option>
                <option value="11v11" <?= old('format') === '11v11' ? 'selected' : '' ?>>11 vs 11</option>
            </select>
        </div>

        <!-- TYPE -->
        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
                <option value="league" <?= old('type', 'league') === 'league' ? 'selected' : '' ?>>
                    Ligue (tous contre tous)
                </option>
                <option value="knockout" <?= old('type') === 'knockout' ? 'selected' : '' ?>>
                    Élimination directe
                </option>
                <option value="groups_knockout" <?= old('type') === 'groups_knockout' ? 'selected' : '' ?>>
                    Poules + phases finales
                </option>
            </select>
        </div>

        <!-- STATUS -->
        <div>
            <label class="block mb-1 font-medium">Statut</label>
            <select name="status"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
                <option value="draft" <?= old('status', 'draft') === 'draft' ? 'selected' : '' ?>>
                    Brouillon (recommandé)
                </option>
                <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>
                    Actif
                </option>
            </select>
        </div>

        <!-- DURÉE -->
        <div>
            <label class="block mb-1 font-medium">Durée du match (minutes)</label>
            <input type="number"
                   name="match_duration"
                   value="<?= old('match_duration', 10) ?>"
                   min="1"
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">

            <p class="text-xs text-gray-400 mt-1">
                Exemple : 10 à 20 minutes
            </p>
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-between items-center pt-4">

            <a href="<?= BASE_URL ?>/index.php?url=tournaments"
               class="text-gray-500 hover:underline">
                Retour
            </a>

            <button class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">
                Créer
            </button>

        </div>

    </form>

</div>