</main>

<!-- FOOTER -->
<footer class="mt-10 border-t bg-white">

    <div class="max-w-6xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">

        <!-- LEFT -->
        <div class="font-medium text-gray-700">
            <?= e(APP_NAME) ?>
        </div>

        <!-- CENTER -->
        <div class="text-center">
            © <?= date('Y') ?> <?= e(APP_NAME) ?>. Tous droits réservés.
        </div>

        <!-- RIGHT -->
        <div class="flex gap-4">

            <a href="#" class="hover:text-black transition">
                Mentions légales
            </a>

            <a href="#" class="hover:text-black transition">
                Confidentialité
            </a>

        </div>

    </div>

</footer>

</body>
</html>