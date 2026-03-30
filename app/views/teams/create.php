<form method="POST" action="<?= BASE_URL ?>/index.php?url=teams/store" class="bg-white rounded-2xl shadow p-6 space-y-5 max-w-xl">

    <input type="hidden" name="tournament_id" value="<?= (int)$tournament['id'] ?>">

    <!-- NOM ÉQUIPE -->
    <div>
        <label class="block mb-1 font-medium">Nom de l'équipe</label>
        <input type="text"
               name="team_name"
               placeholder="Ex: FC Barcelone"
               required
               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-800">
    </div>

    <!-- JOUEURS -->
    <div>
        <label class="block mb-2 font-medium">Joueurs</label>

        <div id="players-container" class="space-y-2">

            <!-- JOUEUR 1 -->
            <div class="flex gap-2 items-center player-row">
                <input type="text" name="players[]" placeholder="Nom joueur"
                       class="border rounded px-3 py-2 w-full" required>

                <input type="number" name="numbers[]" placeholder="#"
                       class="border rounded px-3 py-2 w-20" min="0">

                <button type="button" onclick="removePlayer(this)"
                        class="text-red-500 text-sm">✖</button>
            </div>

        </div>

        <!-- ACTIONS -->
        <div class="flex justify-between mt-3">

            <button type="button"
                    onclick="addPlayer()"
                    class="text-blue-600 hover:underline text-sm">
                + Ajouter joueur
            </button>

            <span class="text-xs text-gray-400">
                max 11 joueurs
            </span>

        </div>
    </div>

    <!-- SUBMIT -->
    <div class="pt-4 flex justify-between items-center">

        <a href="<?= BASE_URL ?>/index.php?url=teams&tournament_id=<?= (int)$tournament['id'] ?>"
           class="text-gray-500 hover:underline">
            ← Retour
        </a>

        <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition">
            ⚽ Créer équipe
        </button>

    </div>

</form>

<script>
function addPlayer() {
    const container = document.getElementById('players-container');

    // 🔥 LIMIT
    if (container.children.length >= 11) {
        alert("Maximum 11 joueurs");
        return;
    }

    const div = document.createElement('div');
    div.className = 'flex gap-2 items-center player-row mt-2';

    div.innerHTML = `
        <input type="text" name="players[]" placeholder="Nom joueur"
               class="border rounded px-3 py-2 w-full" required>

        <input type="number" name="numbers[]" placeholder="#"
               class="border rounded px-3 py-2 w-20" min="0">

        <button type="button" onclick="removePlayer(this)"
                class="text-red-500 text-sm">✖</button>
    `;

    container.appendChild(div);
}

function removePlayer(button) {
    const container = document.getElementById('players-container');

    // 🔥 minimum 1 joueur
    if (container.children.length <= 1) {
        alert("Au moins 1 joueur requis");
        return;
    }

    button.parentElement.remove();
}
</script>