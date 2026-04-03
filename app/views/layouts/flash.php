<?php

$types = [
    'success' => ['bg-green-50 border-green-200 text-green-700'],
    'error'   => ['bg-red-50 border-red-200 text-red-700'],
    'info'    => ['bg-blue-50 border-blue-200 text-blue-700'],
];

?>

<div id="flash-container" class="fixed top-5 right-5 z-50 space-y-3 w-[300px] max-w-[90%]">

<?php foreach ($types as $type => [$class]): ?>

    <?php if ($msg = getFlash($type)): ?>

        <div class="flash-item <?= $class ?> border px-4 py-3 rounded-lg shadow flex items-start justify-between gap-3 animate-fade-in">

            <span class="text-sm leading-snug">
                <?= e($msg) ?>
            </span>

            <!-- CLOSE -->
            <button onclick="removeFlash(this.parentElement)"
                    class="text-gray-400 hover:text-black text-xs">
                ✕
            </button>

        </div>

    <?php endif; ?>

<?php endforeach; ?>

</div>

<style>

/* entrée */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.25s ease;
}

/* sortie */
@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(20px);
    }
}

.animate-fade-out {
    animation: fadeOut 0.25s ease forwards;
}

</style>

<script>

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.flash-item').forEach(el => {
        setTimeout(() => {
            removeFlash(el);
        }, 3000);
    });

});

function removeFlash(el) {
    if (!el) return;

    el.classList.add('animate-fade-out');

    setTimeout(() => {
        el.remove();
    }, 250);
}

</script>