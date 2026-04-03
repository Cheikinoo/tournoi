<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow space-y-6">

        <!-- HEADER -->
        <div class="text-center">
            <h2 class="text-2xl font-bold">
                Connexion
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Accède à ton espace tournoi
            </p>
        </div>

        <!-- FORM -->
        <form method="POST"
              action="<?= BASE_URL ?>/index.php?url=login"
              class="space-y-4">

            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

            <!-- EMAIL -->
            <div>
                <label class="block mb-1 text-sm font-medium">Email</label>
                <input type="email"
                       name="email"
                       placeholder="exemple@email.com"
                       required
                       autocomplete="email"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block mb-1 text-sm font-medium">Mot de passe</label>
                <input type="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       autocomplete="current-password"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
            </div>

            <!-- OPTIONS -->
            <div class="flex justify-between items-center text-sm">

                <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                    <input type="checkbox" name="remember" class="accent-black">
                    Se souvenir
                </label>

                <!-- désactivé proprement -->
                <span class="text-gray-400 cursor-not-allowed">
                    Mot de passe oublié
                </span>

            </div>

            <!-- SUBMIT -->
            <button id="submitBtn"
                    class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition font-semibold">
                Se connecter
            </button>

        </form>

        <!-- DIVIDER -->
        <div class="flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400">ou</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- REGISTER -->
        <p class="text-center text-sm text-gray-500">
            Pas encore de compte ?
            <a href="<?= BASE_URL ?>/index.php?url=register"
               class="text-gray-900 hover:underline font-medium">
                S’inscrire
            </a>
        </p>

    </div>

</div>

<script>

const form = document.querySelector('form');
const btn = document.getElementById('submitBtn');

form.addEventListener('submit', () => {
    btn.innerText = "Connexion...";
    btn.disabled = true;
});

</script>