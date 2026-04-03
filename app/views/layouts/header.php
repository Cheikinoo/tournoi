<?php require_once __DIR__ . '/../../core/Helpers.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= e(APP_NAME) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<?php
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
?>

<body class="bg-gray-50 text-gray-900">

<!-- NAVBAR -->
<nav class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="<?= BASE_URL ?>/index.php?url=dashboard"
           class="flex items-center gap-2 font-semibold text-lg">
            <span class="text-xl">🏆</span>
            <span><?= e(APP_NAME) ?></span>
        </a>

        <?php if (Auth::check()): ?>

            <?php $current = $_GET['url'] ?? ''; ?>

            <div class="flex items-center gap-6 text-sm">

                <!-- NAV -->
                <a href="<?= BASE_URL ?>/index.php?url=dashboard"
                   class="pb-1 border-b-2 <?= str_contains($current, 'dashboard') ? 'border-black text-black font-medium' : 'border-transparent text-gray-500 hover:text-black' ?>">
                    Dashboard
                </a>

                <a href="<?= BASE_URL ?>/index.php?url=tournaments"
                   class="pb-1 border-b-2 <?= str_contains($current, 'tournaments') ? 'border-black text-black font-medium' : 'border-transparent text-gray-500 hover:text-black' ?>">
                    Tournois
                </a>

                <!-- USER -->
                <div class="flex items-center gap-3">

                    <a href="<?= BASE_URL ?>/index.php?url=logout"
                       class="bg-gray-900 text-white px-3 py-1.5 rounded-lg hover:bg-gray-800 text-xs">
                        Déconnexion
                    </a>

                </div>

            </div>

        <?php endif; ?>

    </div>
</nav>

<!-- FLASH -->
<div class="max-w-6xl mx-auto px-6 mt-4 space-y-2">

    <?php if ($msg = getFlash('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            <?= e($msg) ?>
        </div>
    <?php endif; ?>

    <?php if ($msg = getFlash('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            <?= e($msg) ?>
        </div>
    <?php endif; ?>

</div>

<!-- MAIN -->
<main class="max-w-6xl mx-auto px-6 py-6">