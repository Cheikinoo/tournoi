<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-6xl mx-auto px-6 py-8 space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-3xl font-bold">📊 Classement</h1>
            <p class="text-gray-500 text-sm"><?= e($tournament['name']) ?></p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int)$tournament['id'] ?>"
           class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
            ⚽ Voir les matchs
        </a>
    </div>

    <!-- MESSAGE -->
    <?php if (empty($standings)): ?>
        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl text-sm text-yellow-800">
            Aucun classement pour le moment. Joue des matchs pour le générer.
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-4 text-left">#</th>
                    <th class="p-4 text-left">Équipe</th>
                    <th class="p-4 text-center">MJ</th>
                    <th class="p-4 text-center">V</th>
                    <th class="p-4 text-center">N</th>
                    <th class="p-4 text-center">D</th>
                    <th class="p-4 text-center">BP</th>
                    <th class="p-4 text-center">BC</th>
                    <th class="p-4 text-center">Diff</th>
                    <th class="p-4 text-right">Pts</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($standings)): ?>

                    <?php foreach ($standings as $i => $team): ?>

                        <?php
                            $position = $i + 1;
                            $diff = (int)$team['goal_difference'];

                            // 🎨 Couleurs podium
                            $rowClass = '';
                            if ($position === 1) $rowClass = 'bg-yellow-50';
                            elseif ($position === 2) $rowClass = 'bg-gray-50';
                            elseif ($position === 3) $rowClass = 'bg-orange-50';
                        ?>

                        <tr class="border-t hover:bg-gray-50 transition <?= $rowClass ?>">

                            <!-- POSITION -->
                            <td class="p-4 font-bold text-lg">
                                <?php if ($position === 1): ?>🥇
                                <?php elseif ($position === 2): ?>🥈
                                <?php elseif ($position === 3): ?>🥉
                                <?php else: ?>
                                    <?= $position ?>
                                <?php endif; ?>
                            </td>

                            <!-- TEAM -->
                            <td class="p-4 font-semibold">
                                <div class="flex items-center gap-3">

                                    <img src="/assets/logos/<?= e($team['logo'] ?? 'logo1.png') ?>"
                                         class="w-8 h-8 rounded-full object-contain border shadow">

                                    <span><?= e($team['team_name']) ?></span>

                                </div>
                            </td>

                            <!-- STATS -->
                            <td class="p-4 text-center"><?= (int)$team['played'] ?></td>

                            <td class="p-4 text-center text-green-600 font-semibold">
                                <?= (int)$team['wins'] ?>
                            </td>

                            <td class="p-4 text-center">
                                <?= (int)$team['draws'] ?>
                            </td>

                            <td class="p-4 text-center text-red-500">
                                <?= (int)$team['losses'] ?>
                            </td>

                            <td class="p-4 text-center">
                                <?= (int)$team['goals_for'] ?>
                            </td>

                            <td class="p-4 text-center">
                                <?= (int)$team['goals_against'] ?>
                            </td>

                            <!-- DIFF -->
                            <td class="p-4 text-center font-semibold 
                                <?= $diff > 0 ? 'text-green-600' : ($diff < 0 ? 'text-red-500' : 'text-gray-500') ?>">

                                <?= $diff > 0 ? '+' : '' ?><?= $diff ?>

                            </td>

                            <!-- POINTS -->
                            <td class="p-4 text-right font-bold text-xl">
                                <?= (int)$team['points'] ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="10" class="p-10 text-center text-gray-500">

                            <p class="text-lg">Aucun classement disponible</p>

                            <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int)$tournament['id'] ?>"
                               class="bg-black text-white px-4 py-2 rounded-lg mt-3 inline-block">
                                Voir les matchs
                            </a>

                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>