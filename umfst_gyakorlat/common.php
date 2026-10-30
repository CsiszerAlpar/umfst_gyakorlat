<?php
declare(strict_types=1);

// Hibák megjelenítése fejlesztés alatt
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

function db(): PDO {
    static $pdo = null;
    $pdo ??= new PDO('mysql:host=localhost;dbname=umfst;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}

function e(string $s): string { 
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); 
}

function csrf_token(): string { 
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); 
}

/** Egy oldalletöltés rögzítése; visszaadja a megjelenítendő adatokat. */
function latogatas_rogzitese(string $oldal): array {
    // 1) munkamenet (szerveroldali, böngészőnként)
    $_SESSION['letoltes'][$oldal] = ($_SESSION['letoltes'][$oldal] ?? 0) + 1;
    $uj = empty($_SESSION['szamolva']);
    $_SESSION['szamolva'] = true;

    // 2) adatbázis (közös, atomikus növelés)
    db()->prepare(
        'INSERT INTO napi_stat (datum, oldal, letoltes, egyedi) VALUES (CURRENT_DATE, ?, 1, ?)
         ON DUPLICATE KEY UPDATE letoltes = letoltes + 1, egyedi = egyedi + VALUES(egyedi)'
    )->execute([$oldal, $uj ? 1 : 0]);
    
    $ma = db()->query('SELECT COALESCE(SUM(letoltes),0) AS ossz, COALESCE(SUM(egyedi),0) AS egyedi
                       FROM napi_stat WHERE datum = CURRENT_DATE')->fetch();

    // 3) tartós süti (kliensoldali → validálni kell)
    $utolso = filter_var($_COOKIE['utolso'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($utolso !== false && $utolso > time()) {
        $utolso = false;
    }
    setcookie('utolso', (string)time(), [
        'expires' => time() + 30 * 24 * 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']),
    ]);

    return [
        'munkamenetben' => $_SESSION['letoltes'][$oldal],
        'utolso' => $utolso === false ? null : $utolso,
        'ma_ossz' => (int)$ma['ossz'],
        'ma_egyedi' => (int)$ma['egyedi'],
    ];
}