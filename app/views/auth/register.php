<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">

        <!-- HEADER -->
        <h2 class="text-2xl font-bold mb-2 text-center">
            🚀 Créer un compte
        </h2>

        <p class="text-gray-500 text-sm text-center mb-6">
            Commence à gérer tes tournois dès maintenant
        </p>

        <form method="POST" action="<?= BASE_URL ?>/index.php?url=register" class="space-y-4">

            <!-- CSRF -->
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

            <!-- NAME -->
            <div>
                <label class="block text-sm mb-1 font-medium">Nom</label>
                <input type="text"
                       name="name"
                       placeholder="Ex: John Doe"
                       required
                       autocomplete="name"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm mb-1 font-medium">Email</label>
                <input type="email"
                       name="email"
                       placeholder="exemple@email.com"
                       required
                       autocomplete="email"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600">
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
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600">
            </div>

            <!-- SUBMIT -->
            <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                S’inscrire
            </button>

        </form>

        <!-- FOOTER -->
        <p class="text-center text-sm mt-5 text-gray-500">
            Déjà un compte ?
            <a href="<?= BASE_URL ?>/index.php?url=login"
               class="text-blue-600 hover:underline">
                Se connecter
            </a>
        </p>

    </div>

</div>