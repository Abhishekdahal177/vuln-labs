<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

$out = '';
$err = '';
if (isset($_GET['view'])) {
    $v = $_GET['view'];
    // Blocks direct .php reading but NOT php://filter wrapper
    if (preg_match('/\.php$/i', $v) && strpos($v, 'php://') === false) {
        $err = "Direct PHP file access is restricted. Try a different approach.";
    } elseif (file_exists($v) || strpos($v, 'php://') === 0) {
        $out = file_get_contents($v);
    } else {
        $err = "File not found: " . htmlspecialchars($v);
    }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>BidZone Admin Dashboard</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#1a1a2e;color:#e8e8f0;}nav{background:#16213e;padding:0.8rem 2rem;display:flex;justify-content:space-between;border-bottom:2px solid #e94560;}nav h1{color:#e94560;font-size:1rem;}nav span{font-size:0.78rem;color:#a8b2d8;}.layout{display:grid;grid-template-columns:180px 1fr;min-height:calc(100vh - 45px);}.sidebar{background:#0d0d1a;padding:1rem 0;border-right:1px solid #2a2a4a;}.sidebar a{display:block;color:#a8b2d8;text-decoration:none;padding:0.65rem 1rem;font-size:0.8rem;}.sidebar a:hover{color:#e94560;}.sidebar .lbl{font-size:0.62rem;color:#4a4a6a;padding:0.8rem 1rem 0.3rem;text-transform:uppercase;letter-spacing:0.08em;}.main{padding:1.5rem;}h2{font-size:1rem;color:#e94560;margin-bottom:1rem;padding-bottom:0.4rem;border-bottom:1px solid #2a2a4a;}.card{background:#16213e;border-radius:8px;padding:1.5rem;border:1px solid #2a2a4a;margin-bottom:1.5rem;}.flag-box{background:#0a2a0a;color:#00ff88;font-family:monospace;padding:0.8rem 1rem;border-radius:6px;text-align:center;margin-bottom:1rem;}input[type=text]{width:80%;padding:7px 12px;background:#0d0d1a;border:1px solid #2a2a4a;border-radius:6px;color:#e8e8f0;font-family:monospace;font-size:0.8rem;}button{padding:7px 14px;background:#e94560;color:white;border:none;border-radius:6px;cursor:pointer;margin-left:6px;}pre{background:#0d0d1a;color:#58a6ff;font-size:0.73rem;padding:1rem;border-radius:6px;white-space:pre-wrap;max-height:300px;overflow-y:auto;margin-top:0.8rem;word-break:break-all;}.err-msg{color:#e94560;font-size:0.82rem;margin-top:0.5rem;font-style:italic;}.url-note{font-size:0.67rem;color:#4a4a6a;font-family:monospace;margin-top:4px;}.hint{font-size:0.72rem;color:#6b6b85;margin-top:0.5rem;}</style>
</head><body>
<nav><h1>🔨 BidZone Admin</h1><span>Admin: <?php echo $_SESSION['admin']; ?> | <a href="logout.php" style="color:#e94560">Logout</a></span></nav>
<div class="layout">
<aside class="sidebar">
  <div class="lbl">Panel</div>
  <a href="dashboard.php">🏠 Dashboard</a>
  <div class="lbl">File Viewer</div>
  <a href="dashboard.php?view=/etc/passwd">👥 /etc/passwd</a>
  <a href="dashboard.php?view=/etc/hostname">🖥 Hostname</a>
  <a href="dashboard.php?view=config.php">⚙️ Config (blocked)</a>
  <div class="lbl">Account</div>
  <a href="logout.php">🚪 Logout</a>
</aside>
<main class="main">
  <h2>Dashboard</h2>
  <div class="card">
    <div class="flag-box">FLAG1{b1dz0ne_adm1n_panel_sql1_byp4ss}</div>
  </div>
  <h2>File Viewer</h2>
  <div class="card">
    <p style="font-size:0.8rem;color:#6b6b85;margin-bottom:0.8rem;">View server files. Note: direct .php access is restricted.</p>
    <form method="GET">
      <input type="text" name="view" value="<?php echo htmlspecialchars($_GET['view'] ?? ''); ?>" placeholder="/etc/passwd or php://filter/convert.base64-encode/resource=config.php">
      <button>View</button>
    </form>
    <div class="url-note">dashboard.php?view=<?php echo htmlspecialchars($_GET['view'] ?? ''); ?></div>
    <?php if($err): ?><div class="err-msg">⚠ <?php echo $err; ?></div>
    <div class="hint">💡 Hint: PHP stream wrappers may bypass this restriction...</div>
    <?php endif; ?>
    <?php if($out): ?><pre><?php echo htmlspecialchars($out); ?></pre><?php endif; ?>
  </div>
</main>
</div>
</body></html>
