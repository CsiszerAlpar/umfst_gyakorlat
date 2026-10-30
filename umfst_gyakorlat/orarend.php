<?php 
require __DIR__ . '/common.php';
$adat = latogatas_rogzitese('orarend');      
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Órarend – UMFST</title>
</head>
<body>
    <nav>
        <a href="/umfst_gyakorlat/index.php">Kezdőlap</a> · 
        <a href="/umfst_gyakorlat/orarend.php">Órarend</a>
    </nav>
    
    <h1>Órarend</h1>
    
    <p>
      <?php if ($adat['utolso'] !== null): ?>
        Utoljára itt jártál: <strong><?= e(date('Y.m.d. H:i', $adat['utolso'])) ?></strong>
      <?php else: ?>
        Üdv, először jársz itt!
      <?php endif; ?>
    </p>
    
    <p>Ebben a munkamenetben <?= (int)$adat['munkamenetben'] ?>. alkalommal töltötted be az órarend oldalt.</p>
    <p>Ma összesen <?= (int)$adat['ma_ossz'] ?> letöltés, <?= (int)$adat['ma_egyedi'] ?> egyedi látogató.</p>
</body>
</html>