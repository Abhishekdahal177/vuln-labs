<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

$file_out = '';
if (isset($_GET['template'])) {
    $t = $_GET['template'];
    // VULNERABLE LFI - renders any file
    if (file_exists($t)) {
        ob_start();
        include($t);
        $file_out = ob_get_clean();
        if (empty($file_out)) $file_out = file_get_contents($t);
    } else {
        $file_out = "Template not found: " . htmlspecialchars($t);
    }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>TravelHub Dashboard</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#f0f7ff;}nav{background:#0d3b6e;color:white;padding:0.8rem 2rem;display:flex;justify-content:space-between;align-items:center;}nav h1{font-size:1rem;color:#a8d4ff;}nav span{font-size:0.78rem;color:#7ab3e0;}.layout{display:grid;grid-template-columns:190px 1fr;min-height:calc(100vh - 46px);}.sidebar{background:#1a4a7a;padding:1rem 0;}.sidebar a{display:block;color:#a8d4ff;text-decoration:none;padding:0.65rem 1.2rem;font-size:0.8rem;}.sidebar a:hover{background:#0d3b6e;color:white;}.sidebar .lbl{font-size:0.62rem;color:#4a7aaa;padding:0.8rem 1.2rem 0.3rem;text-transform:uppercase;letter-spacing:0.08em;}.main{padding:1.5rem;}h2{font-size:1rem;color:#0d3b6e;margin-bottom:1rem;padding-bottom:0.5rem;border-bottom:2px solid #a8d4ff;}.card{background:white;border-radius:8px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin-bottom:1.5rem;}.flag-box{background:#1a3a1a;color:#00ff88;font-family:monospace;font-size:1rem;padding:1rem;border-radius:6px;text-align:center;letter-spacing:0.05em;margin-bottom:1rem;}input[type=text]{padding:7px 12px;border:1.5px solid #ddd;border-radius:6px;font-size:0.82rem;font-family:monospace;width:70%;}button{padding:7px 16px;background:#1a6bb5;color:white;border:none;border-radius:6px;cursor:pointer;margin-left:6px;}pre{background:#0d1117;color:#58a6ff;font-size:0.75rem;padding:1rem;border-radius:6px;white-space:pre-wrap;max-height:320px;overflow-y:auto;margin-top:0.8rem;word-break:break-all;}.url-note{font-size:0.68rem;color:#aaa;font-family:monospace;margin-top:4px;}</style>
</head><body>
<nav><h1>✈️ TravelHub Admin</h1><span>Welcome, <?php echo $_SESSION['admin']; ?> | <a href="logout.php" style="color:#a8d4ff">Logout</a></span></nav>
<div class="layout">
<aside class="sidebar">
  <div class="lbl">Admin</div>
  <a href="dashboard.php">🏠 Home</a>
  <div class="lbl">Templates</div>
  <a href="dashboard.php?template=templates/home.html">🌍 Home Page</a>
  <a href="dashboard.php?template=templates/about.html">ℹ️ About</a>
  <a href="dashboard.php?template=config.php">⚙️ Config</a>
  <div class="lbl">System</div>
  <a href="dashboard.php?template=/etc/passwd">👥 Users</a>
  <a href="logout.php">🚪 Logout</a>
</aside>
<main class="main">
  <h2>Admin Dashboard</h2>
  <div class="card">
    <div class="flag-box">FLAG1{welc0me_t0_tr4velHub_adm1n_panel}</div>
    <p style="font-size:0.82rem;color:#555;">You have successfully accessed the admin panel.</p>
  </div>
  <h2>Template Viewer</h2>
  <div class="card">
    <form method="GET">
      <input type="text" name="template" value="<?php echo htmlspecialchars($_GET['template'] ?? ''); ?>" placeholder="templates/home.html or config.php or /etc/passwd">
      <button>Load</button>
    </form>
    <div class="url-note">dashboard.php?template=<?php echo htmlspecialchars($_GET['template'] ?? ''); ?></div>
    <?php if ($file_out): ?><pre><?php echo htmlspecialchars($file_out); ?></pre><?php endif; ?>
  </div>
</main>
</div>
</body></html>
