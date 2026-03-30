<?php

// 🔥 SUCCESS
if ($msg = getFlash('success')): ?>
    <div class="fixed top-5 right-5 z-50">
        <div class="bg-green-100 text-green-800 px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in">
            <span class="text-lg">✅</span>
            <span><?= e($msg) ?></span>
        </div>
    </div>
<?php endif; ?>

<?php

// 🔥 ERROR
if ($msg = getFlash('error')): ?>
    <div class="fixed top-5 right-5 z-50">
        <div class="bg-red-100 text-red-800 px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in">
            <span class="text-lg">❌</span>
            <span><?= e($msg) ?></span>
        </div>
    </div>
<?php endif; ?>

<?php

// 🔥 INFO (optionnel)
if ($msg = getFlash('info')): ?>
    <div class="fixed top-5 right-5 z-50">
        <div class="bg-blue-100 text-blue-800 px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in">
            <span class="text-lg">ℹ️</span>
            <span><?= e($msg) ?></span>
        </div>
    </div>
<?php endif; ?>

<style>
/* 🔥 animation douce */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease;
}
</style>