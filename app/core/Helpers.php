<?php

/*
|--------------------------------------------------------------------------
| ESCAPE (XSS PROTECTION)
|--------------------------------------------------------------------------
*/
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/*
|--------------------------------------------------------------------------
| FLASH MESSAGES
|--------------------------------------------------------------------------
*/
function setFlash(string $key, string $message): void
{
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }

    $_SESSION['flash'][$key] = $message;
}

function getFlash(string $key): ?string
{
    if (!empty($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
*/
function required($value): bool
{
    return trim((string)$value) !== '';
}

function email(string $value): bool
{
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

function minLength(string $value, int $length): bool
{
    return mb_strlen(trim($value)) >= $length;
}

/*
|--------------------------------------------------------------------------
| REDIRECT HELPER
|--------------------------------------------------------------------------
*/
function redirect(string $url): void
{
    header('Location: ' . BASE_URL . '/index.php?url=' . $url);
    exit;
}

/*
|--------------------------------------------------------------------------
| CSRF PROTECTION (🔥 IMPORTANT)
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| CSRF PROTECTION (🔥 FIX TOTAL)
|--------------------------------------------------------------------------
*/
function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
    }

    return $_SESSION['csrf'];
}

function verifyCsrf(): bool
{
    if (!isset($_POST['csrf'], $_SESSION['csrf'])) {
        return false;
    }

    $valid = hash_equals($_SESSION['csrf'], $_POST['csrf']);

    // 🔥 IMPORTANT : on invalide après usage
    unset($_SESSION['csrf']);

    return $valid;
}
/*
|--------------------------------------------------------------------------
| OLD INPUT (🔥 UX PRO)
|--------------------------------------------------------------------------
*/
function old(string $key, $default = ''): string
{
    return e($_SESSION['old'][$key] ?? $default);
}

function setOld(array $data): void
{
    $_SESSION['old'] = $data;
}


function clearOld(): void
{
    unset($_SESSION['old']);
}