<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center flex-wrap gap-3">
        <div>
            <h1 class="text-3xl font-bold">Mes tournois</h1>
            <p class="text-gray-500 text-sm mt-1">
                Gère rapidement tous tes tournois
            </p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
           class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-800">
            Nouveau tournoi
        </a>
    </div>

    <!-- EMPTY -->
    <?php if (empty($tournaments)): ?>

        <div class="bg-white rounded-2xl shadow p-10 text-center text-gray-500">

            <p class="text-lg mb-2">Aucun tournoi</p>
            <p class="text-sm mb-4">Crée ton premier tournoi</p>

            <a href="<?= BASE_URL ?>/index.php?url=tournaments/create"
               class="bg-gray-900 text-white px-5 py-2 rounded-lg">
                Créer un tournoi
            </a>

        </div>

    <?php else: ?>

    <!-- LIST -->
    <div class="space-y-4">

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

                $id = (int)$tournament['id'];
            ?>

            <div class="bg-white rounded-2xl shadow p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <!-- INFOS -->
                <div>
                    <h2 class="text-lg font-semibold">
                        <?= e($tournament['name']) ?>
                    </h2>

                    <p class="text-sm text-gray-500">
                        Format: <?= e($tournament['format']) ?>
                    </p>

                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                        <?= e($tournament['status']) ?>
                    </span>
                </div>

                <!-- ACTIONS -->
                <div class="flex flex-wrap gap-2">

                    <!-- ACTION PRINCIPALE -->
                    <a href="<?= BASE_URL ?>/index.php?url=tournaments/show&id=<?= $id ?>"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Gérer
                    </a>

                    <!-- ACCÈS RAPIDES -->
                    <a href="<?= BASE_URL ?>/index.php?url=teams&tournament_id=<?= $id ?>"
                       class="bg-gray-100 px-3 py-2 rounded-lg hover:bg-gray-200 text-sm">
                        Équipes
                    </a>

                    <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= $id ?>"
                       class="bg-gray-100 px-3 py-2 rounded-lg hover:bg-gray-200 text-sm">
                        Matchs
                    </a>

                    <a href="<?= BASE_URL ?>/index.php?url=standings&tournament_id=<?= $id ?>"
                       class="bg-gray-100 px-3 py-2 rounded-lg hover:bg-gray-200 text-sm">
                        Classement
                    </a>

                    <!-- SECONDAIRE -->
                    <a href="<?= BASE_URL ?>/index.php?url=tournaments/edit&id=<?= $id ?>"
                       class="text-gray-400 hover:text-black text-sm">
                        Modifier
                    </a>

                    <form method="POST"
                          action="<?= BASE_URL ?>/index.php?url=tournaments/delete"
                          onsubmit="return confirm('Supprimer ce tournoi ?')">

                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">

                        <button class="text-red-500 text-sm hover:underline">
                            Supprimer
                        </button>
                    </form>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

</div>