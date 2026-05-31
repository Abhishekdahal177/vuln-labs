<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

$out = '';
if (isset($_GET['file'])) {
    $f = $_GET['file'];
    // Path traversal vulnerable — no filtering of ../
    $base = '/var/www/html/pages/';
    $full = $base . $f;
    // Uses realpath but doesn't restrict — still traversable
    if (file_exists($full)) {
        $out = file_get_contents($full);
    } elseif (file_exists($f)) {
        $out = file_get_contents($f);
    } else {
        $out = "Not found: " . htmlspecialchars($f);
    }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>QuickBite Dashboard</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#fff9f0;}nav{background:#e74c3c;color:white;padding:0.8rem 2rem;display:flex;justify-content:space-between;}nav h1{font-size:1rem;}nav span{font-size:0.78rem;}.layout{display:grid;grid-template-columns:190px 1fr;min-height:calc(100vh - 46px);}.sidebar{background:#c0392b;padding:1rem 0;}.sidebar a{display:block;color:#ffcccc;text-decoration:none;padding:0.65rem 1.2rem;font-size:0.8rem;}.sidebar a:hover{background:#a93226;color:white;}.sidebar .lbl{font-size:0.62rem;color:#e8a89e;padding:0.8rem 1.2rem 0.3rem;text-transform:uppercase;letter-spacing:0.08em;}.main{padding:1.5rem;}h2{font-size:1rem;color:#c0392b;margin-bottom:1rem;padding-bottom:0.4rem;border-bottom:2px solid #fadbd8;}.card{background:white;border-radius:8px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin-bottom:1.5rem;}.flag-box{background:#0a2a0a;color:#00ff88;font-family:monospace;padding:0.8rem;border-radius:6px;text-align:center;margin-bottom:1rem;}input[type=text]{padding:7px 12px;border:1.5px solid #ddd;border-radius:6px;font-size:0.82rem;font-family:monospace;width:70%;}button{padding:7px 14px;background:#e74c3c;color:white;border:none;border-radius:6px;cursor:pointer;margin-left:6px;}pre{background:#1a0a0a;color:#ff9999;font-family:monospace;font-size:0.73rem;padding:1rem;border-radius:6px;white-space:pre-wrap;max-height:300px;overflow-y:auto;margin-top:0.8rem;word-break:break-all;}.url-note{font-size:0.67rem;color:#aaa;font-family:monospace;margin-top:4px;}</style>
</head><body>
<nav><h1>🍜 QuickBite Admin</h1><span>Admin: <?php echo $_SESSION['admin']; ?> | <a href="logout.php" style="color:#ffcccc">Logout</a></span></nav>
<div class="layout">
<aside class="sidebar">
  <div class="lbl">Admin</div>
  <a href="dashboard.php">🏠 Dashboard</a>
  <div class="lbl">File Manager</div>
  <a href="dashboard.php?file=menu.txt">📄 Menu File</a>
  <a href="dashboard.php?file=../../etc/passwd">👥 /etc/passwd</a>
  <a href="dashboard.php?file=../../etc/hostname">🖥 Hostname</a>
  <a href="dashboard.php?file=../../var/www/html/config.php">⚙️ Config</a>
  <div class="lbl">System</div>
  <a href="logout.php">🚪 Logout</a>
</aside>
<main class="main">
  <h2>Dashboard</h2>
  <div class="card">
    <div class="flag-box">FLAG1{qu1ckb1te_adm1n_sql1_0wn3d}</div>
  </div>
  <h2>File Manager</h2>
  <div class="card">
    <p style="font-size:0.8rem;color:#888;margin-bottom:0.8rem;">Browse server files. Base path: /var/www/html/pages/</p>
    <form method="GET">
      <input type="text" name="file" value="<?php echo htmlspecialchars($_GET['file'] ?? ''); ?>" placeholder="menu.txt or ../../etc/passwd or ../../var/www/html/config.php">
      <button>Read</button>
    </form>
    <div class="url-note">dashboard.php?file=<?php echo htmlspecialchars($_GET['file'] ?? ''); ?></div>
    <?php if($out): ?><pre><?php echo htmlspecialchars($out); ?></pre><?php endif; ?>
  </div>
</main>
</div>
</body></html>
