<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-2xl mx-auto px-6 py-8 space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold">Créer une équipe</h1>
        <p class="text-gray-500 text-sm">
            <?= e($tournament['name']) ?>
        </p>
    </div>

    <!-- INFO -->
    <div class="bg-gray-50 border p-4 rounded-xl text-sm text-gray-700">
        Ajoute entre <strong>1 et 11 joueurs</strong>
    </div>

    <!-- FORM -->
    <form method="POST"
          action="<?= BASE_URL ?>/index.php?url=teams/store"
          class="bg-white rounded-2xl shadow p-6 space-y-6">

        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
        <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

        <!-- NOM -->
        <div>
            <label class="block mb-1 font-medium">Nom</label>
            <input type="text"
                   name="name"
                   placeholder="Ex: FC Barcelone"
                   required
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
        </div>

        <!-- JOUEURS -->
        <div>
            <label class="block mb-2 font-medium">Joueurs</label>

            <div id="players-container" class="space-y-3">

                <div class="flex gap-2 items-center player-row bg-gray-50 p-2 rounded-lg">
                    <input type="text" name="players[]" placeholder="Nom"
                           class="border rounded px-3 py-2 w-full" required>

                    <input type="number" name="numbers[]" placeholder="#"
                           class="border rounded px-3 py-2 w-20" min="0">

                    <button type="button" onclick="removePlayer(this)"
                            class="text-red-500 text-sm">Suppr</button>
                </div>

            </div>

            <!-- ACTIONS -->
            <div class="flex justify-between items-center mt-3">

                <button type="button"
                        onclick="addPlayer()"
                        class="text-gray-700 hover:underline text-sm">
                    Ajouter un joueur
                </button>

                <span id="player-count" class="text-xs text-gray-400">
                    1 / 11
                </span>

            </div>

        </div>

        <!-- ACTIONS -->
        <div class="pt-4 flex justify-between items-center">

            <a href="<?= BASE_URL ?>/index.php?url=teams&tournament_id=<?= (int)$tournament['id'] ?>"
               class="text-gray-500 hover:underline">
                Retour
            </a>

            <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">
                Créer l'équipe
            </button>

        </div>

    </form>

</div>

<script>

function updateCount() {
    const count = document.getElementById('players-container').children.length;
    document.getElementById('player-count').innerText = count + ' / 11';
}

function addPlayer() {
    const container = document.getElementById('players-container');

    if (container.children.length >= 11) {
        showMessage("Maximum 11 joueurs", "error");
        return;
    }

    const div = document.createElement('div');
    div.className = 'flex gap-2 items-center player-row bg-gray-50 p-2 rounded-lg';

    div.innerHTML = `
        <input type="text" name="players[]" placeholder="Nom"
               class="border rounded px-3 py-2 w-full" required>

        <input type="number" name="numbers[]" placeholder="#"
               class="border rounded px-3 py-2 w-20" min="0">

        <button type="button" onclick="removePlayer(this)"
                class="text-red-500 text-sm">Suppr</button>
    `;

    container.appendChild(div);
    updateCount();
}

function removePlayer(button) {
    const container = document.getElementById('players-container');

    if (container.children.length <= 1) {
        showMessage("Minimum 1 joueur", "error");
        return;
    }

    button.parentElement.remove();
    updateCount();
}

function showMessage(text, type) {
    const div = document.createElement('div');
    div.innerText = text;

    div.className = `
        fixed top-5 right-5 px-4 py-2 rounded shadow text-white text-sm
        ${type === "error" ? "bg-red-500" : "bg-green-500"}
    `;

    document.body.appendChild(div);

    setTimeout(() => {
        div.style.opacity = "0";
        setTimeout(() => div.remove(), 300);
    }, 1800);
}

updateCount();

</script>