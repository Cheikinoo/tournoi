<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-md">

        <!-- HEADER -->
        <h2 class="text-2xl font-bold mb-2 text-center">
            🔐 Connexion
        </h2>

        <p class="text-gray-500 text-sm text-center mb-6">
            Accède à ton espace tournoi
        </p>

        <form method="POST"
              action="<?= BASE_URL ?>/index.php?url=login"
              class="space-y-4">

            <!-- CSRF -->
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

            <!-- EMAIL -->
            <div>
                <label class="block mb-1 text-sm font-medium">Email</label>
                <input type="email"
                       name="email"
                       placeholder="exemple@email.com"
                       required
                       autocomplete="email"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block mb-1 text-sm font-medium">Mot de passe</label>
                <input type="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       autocomplete="current-password"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
            </div>

            <!-- OPTIONS -->
            <div class="flex justify-between items-center text-sm">

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded">
                    <span class="text-gray-600">Se souvenir de moi</span>
                </label>

                <a href="#" class="text-blue-600 hover:underline">
                    Mot de passe oublié ?
                </a>

            </div>

            <!-- SUBMIT -->
            <button class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition">
                Se connecter
            </button>

        </form>

        <!-- REGISTER -->
        <p class="text-center text-sm mt-5 text-gray-500">
            Pas encore de compte ?
            <a href="<?= BASE_URL ?>/index.php?url=register"
               class="text-blue-600 hover:underline">
                S’inscrire
            </a>
        </p>

    </div>

</div>