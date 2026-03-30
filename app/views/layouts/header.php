<?php require_once __DIR__ . '/../../core/Helpers.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= e(APP_NAME) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
?>
<body class="bg-gray-100 text-gray-900">

<!-- NAVBAR -->
<nav class="bg-white border-b shadow-sm">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="<?= BASE_URL ?>/index.php?url=dashboard"
           class="font-bold text-xl text-gray-900">
            🏆 Tournament
        </a>

        <?php if (Auth::check()): ?>

            <?php
                $current = $_GET['url'] ?? '';
            ?>

            <div class="flex gap-4 items-center text-sm">

                <a href="<?= BASE_URL ?>/index.php?url=dashboard"
                   class="<?= str_contains($current, 'dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-600' ?>">
                    Dashboard
                </a>

                <a href="<?= BASE_URL ?>/index.php?url=tournaments"
                   class="<?= str_contains($current, 'tournaments') ? 'text-blue-600 font-semibold' : 'text-gray-600' ?>">
                    Tournois
                </a>

                <a href="<?= BASE_URL ?>/index.php?url=teams"
                   class="<?= str_contains($current, 'teams') ? 'text-blue-600 font-semibold' : 'text-gray-600' ?>">
                    Équipes
                </a>

                <a href="<?= BASE_URL ?>/index.php?url=logout"
                   class="bg-red-500 text-white px-3 py-1 rounded-lg hover:opacity-90">
                    Déconnexion
                </a>

            </div>

        <?php endif; ?>

    </div>
</nav>

<!-- FLASH MESSAGES -->
<div class="max-w-6xl mx-auto px-6 mt-4">

    <?php if ($msg = getFlash('success')): ?>
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
            <?= e($msg) ?>
        </div>
    <?php endif; ?>

    <?php if ($msg = getFlash('error')): ?>
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
            <?= e($msg) ?>
        </div>
    <?php endif; ?>

</div>

<!-- MAIN CONTENT -->
<main class="max-w-6xl mx-auto px-6 py-6">