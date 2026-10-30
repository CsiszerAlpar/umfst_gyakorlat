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
    <?php 
require __DIR__ . '/common.php';
$adat = latogatas_rogzitese('orarend');      
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Órarend – UMFST</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121824;
            color: #ffffff;
            margin: 0;
            padding: 40px;
        }
        nav a {
            color: #60a5fa;
            text-decoration: none;
            margin-right: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        h1 {
            margin-top: 20px;
        }
        .cards-container {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }
        .card {
            padding: 20px;
            border-radius: 12px;
            color: white;
            min-width: 200px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            position: relative;
        }
        .card.purple { background-color: #7c3aed; }
        .card.blue { background-color: #0284c7; }
        .card.orange { background-color: #d97706; }
        .card .number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card .label {
            font-size: 14px;
            opacity: 0.9;
        }
        .card .badge {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 11px;
            background: rgba(0,0,0,0.2);
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        button {
            background-color: #374151;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background-color: #4b5563;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/umfst_gyakorlat/index.php">Kezdőlap</a> 
        <a href="/umfst_gyakorlat/orarend.php">Órarend</a>
    </nav>
    
    <h1>Órarend</h1>
    
    <p>
      <?php if ($adat['utolso'] !== null): ?>
        Utoljára itt jártál: <strong><?= e(date('Y.m.d. H:i', $adat['utolso'])) ?></strong>
      <?php else: ?>
        Üdv, először jársz itt!
      <?php endif; ?></p>

    <div class="cards-container">
        <!-- Munkamenet kártya (Lila) -->
        <div class="card purple">
            <span class="badge">$_SESSION</span>
            <div class="number"><?= (int)$adat['munkamenetben'] ?>.</div>
            <div class="label">letöltés ebben a munkamenetben</div>
        </div>

        <!-- Összes letöltés kártya (Kék) -->
        <div class="card blue">
            <span class="badge">adatbázis</span>
            <div class="number"><?= (int)$adat['ma_ossz'] ?></div>
            <div class="label">mai összes letöltés</div>
        </div>

        <!-- Egyedi látogató kártya (Narancs) -->
        <div class="card orange">
            <span class="badge">adatbázis</span>
            <div class="number"><?= (int)$adat['ma_egyedi'] ?></div>
            <div class="label">mai egyedi látogató</div>
        </div>
    </div>
    
    <form method="post" action="/umfst_gyakorlat/felejts.php">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <button>Felejts el (sütik törlése)</button>
    </form>
</body>
</html>
    <p>
      <?php if ($adat['utolso'] !== null): ?>
        Utoljára itt jártál: <strong><?= e(date('Y.m.d. H:i', $adat['utolso'])) ?></strong>
      <?php else: ?>
        Üdv, először jársz itt!
      <?php endif; ?>
    </p>
    
    <p>Ebben a munkamenetben <?= (int)$adat['munkamenetben'] ?>. alkalommal töltötted be az órarend oldalt.</p>
    <p>Ma összesen <?= (int)$adat['ma_ossz'] ?> letöltés, <?= (int)$adat['ma_egyedi'] ?> egyedi látogató.</p>

    <form method="post" action="/umfst_gyakorlat/felejts.php">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <button>Felejts el (sütik törlése)</button>
    </form>
</body>
</html>