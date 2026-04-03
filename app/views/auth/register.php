<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="bg-white p-8 rounded-2xl shadow w-full max-w-md space-y-6">

        <!-- HEADER -->
        <div class="text-center">
            <h2 class="text-2xl font-bold">
                Créer un compte
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Lance ton premier tournoi en quelques secondes
            </p>
        </div>

        <!-- FORM -->
        <form method="POST"
              action="<?= BASE_URL ?>/index.php?url=register"
              class="space-y-4">

            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

            <!-- NAME -->
            <div>
                <label class="block text-sm mb-1 font-medium">Nom</label>
                <input type="text"
                       name="name"
                       placeholder="Ex: John Doe"
                       required
                       autocomplete="name"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm mb-1 font-medium">Email</label>
                <input type="email"
                       name="email"
                       placeholder="exemple@email.com"
                       required
                       autocomplete="email"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm mb-1 font-medium">Mot de passe</label>
                <input type="password"
                       name="password"
                       placeholder="Minimum 6 caractères"
                       required
                       minlength="6"
                       autocomplete="new-password"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
                
                <p class="text-xs text-gray-400 mt-1">
                    Minimum 6 caractères
                </p>
            </div>

            <!-- SUBMIT -->
            <button id="submitBtn"
                    class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition font-semibold">
                Créer un compte
            </button>

        </form>

        <!-- DIVIDER -->
        <div class="flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400">ou</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- LOGIN -->
        <p class="text-center text-sm text-gray-500">
            Déjà un compte ?
            <a href="<?= BASE_URL ?>/index.php?url=login"
               class="text-gray-900 hover:underline font-medium">
                Se connecter
            </a>
        </p>

    </div>

</div>

<script>

const form = document.querySelector('form');
const btn = document.getElementById('submitBtn');

form.addEventListener('submit', () => {
    btn.innerText = "Création...";
    btn.disabled = true;
});

</script>