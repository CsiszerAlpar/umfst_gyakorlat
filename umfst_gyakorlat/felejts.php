<?php 
require __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
    http_response_code(403);
    exit('Tiltott kérés.');
}

setcookie('utolso', '', ['expires' => time() - 3600, 'path' => '/']);
$_SESSION = [];
setcookie(session_name(), '', ['expires' => time() - 3600, 'path' => '/']);
session_destroy();

header('Location: /umfst_gyakorlat/index.php', true, 303);
exit;