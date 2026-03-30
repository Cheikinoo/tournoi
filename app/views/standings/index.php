<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-6xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">🏆 Classement</h1>
            <p class="text-gray-500 mt-1"><?= e($tournament['name']) ?></p>
        </div>

        <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int) $tournament['id'] ?>"
           class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
            ⚽ Voir matchs
        </a>
    </div>

    <!-- DEBUG (TEMPORAIRE) -->
    <?php if (empty($standings)): ?>
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            ⚠️ Aucun classement généré (vérifie si les matchs sont bien "played")
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

                    <?php foreach ($standings as $team): ?>

                        <?php
                            $position = $team['position'] ?? 0;

                            $rowClass = '';
                            if ($position === 1) $rowClass = 'bg-yellow-50';
                            elseif ($position === 2) $rowClass = 'bg-gray-50';
                            elseif ($position === 3) $rowClass = 'bg-orange-50';
                        ?>

                        <tr class="border-t hover:bg-gray-50 transition <?= $rowClass ?>">

                            <!-- POSITION -->
                            <td class="p-4 font-bold text-lg">
                                <?php if ($position === 1): ?>
                                    🥇
                                <?php elseif ($position === 2): ?>
                                    🥈
                                <?php elseif ($position === 3): ?>
                                    🥉
                                <?php else: ?>
                                    <?= $position ?>
                                <?php endif; ?>
                            </td>

                            <!-- TEAM -->
                            <td class="p-4 font-semibold">
                                <?= e($team['team_name']) ?>
                            </td>

                            <!-- STATS -->
                            <td class="p-4 text-center"><?= (int) $team['played'] ?></td>
                            <td class="p-4 text-center text-green-600 font-medium"><?= (int) $team['wins'] ?></td>
                            <td class="p-4 text-center"><?= (int) $team['draws'] ?></td>
                            <td class="p-4 text-center text-red-500"><?= (int) $team['losses'] ?></td>

                            <td class="p-4 text-center"><?= (int) $team['goals_for'] ?></td>
                            <td class="p-4 text-center"><?= (int) $team['goals_against'] ?></td>

                            <!-- DIFF -->
                            <td class="p-4 text-center font-medium">
                                <?php
                                    $diff = (int) $team['goal_difference'];
                                    echo ($diff > 0 ? '+' : '') . $diff;
                                ?>
                            </td>

                            <!-- POINTS -->
                            <td class="p-4 text-right font-bold text-lg">
                                <?= (int) $team['points'] ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="10" class="p-10 text-center">

                            <div class="flex flex-col items-center gap-3 text-gray-500">
                                <div class="text-4xl">📊</div>
                                <p>Aucun classement disponible</p>

                                <a href="<?= BASE_URL ?>/index.php?url=matches&tournament_id=<?= (int) $tournament['id'] ?>"
                                   class="bg-black text-white px-4 py-2 rounded-lg mt-2">
                                    Voir les matchs
                                </a>
                            </div>

                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>