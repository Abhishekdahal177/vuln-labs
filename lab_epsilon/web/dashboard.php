<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

$out=''; $err='';
if (isset($_GET['doc'])) {
    $doc = $_GET['doc'];
    // Blocks direct .php AND direct /secure/ access — must use php://filter
    if (preg_match('/\.php$/i', $doc) && strpos($doc,'php://') === false) {
        $err = "PHP files cannot be accessed directly.";
    } elseif (preg_match('#/secure/#', $doc) && strpos($doc,'php://') === false) {
        $err = "The /secure/ directory is restricted. Find another way.";
    } elseif (file_exists($doc) || strpos($doc,'php://') === 0) {
        $out = file_get_contents($doc);
    } else {
        $err = "File not found: " . htmlspecialchars($doc);
    }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>ResearchPortal Staff Dashboard</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#f8f5f0;color:#2c2416;}nav{background:#2c2416;color:#f5e6c8;padding:0.8rem 2rem;display:flex;justify-content:space-between;align-items:center;}nav h1{font-size:1rem;font-family:Georgia,serif;}nav span{font-size:0.78rem;color:#c9a84c;}.layout{display:grid;grid-template-columns:200px 1fr;min-height:calc(100vh - 46px);}.sidebar{background:#3d3020;padding:1rem 0;}.sidebar a{display:block;color:#c9a84c;text-decoration:none;padding:0.65rem 1.2rem;font-size:0.8rem;}.sidebar a:hover{background:#2c2416;color:#f5e6c8;}.sidebar .lbl{font-size:0.62rem;color:#7a6040;padding:0.8rem 1.2rem 0.3rem;text-transform:uppercase;letter-spacing:0.08em;}.main{padding:1.5rem;}h2{font-size:1rem;color:#2c2416;margin-bottom:1rem;padding-bottom:0.4rem;border-bottom:2px solid #c9a84c;}.card{background:white;border-radius:8px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin-bottom:1.5rem;}.flag-box{background:#0a1a0a;color:#00ff88;font-family:monospace;padding:0.8rem;border-radius:6px;text-align:center;margin-bottom:1rem;}input[type=text]{padding:7px 12px;border:1.5px solid #d5c9b0;border-radius:6px;font-size:0.8rem;font-family:monospace;width:75%;}button{padding:7px 14px;background:#2c2416;color:#f5e6c8;border:none;border-radius:6px;cursor:pointer;margin-left:6px;}pre{background:#1a1208;color:#c9a84c;font-family:monospace;font-size:0.73rem;padding:1rem;border-radius:6px;white-space:pre-wrap;max-height:320px;overflow-y:auto;margin-top:0.8rem;word-break:break-all;}.err-msg{color:#c0392b;font-size:0.8rem;margin-top:0.5rem;font-style:italic;}.hint{font-size:0.72rem;color:#888;margin-top:4px;}.url-note{font-size:0.67rem;color:#aaa;font-family:monospace;margin-top:4px;}</style>
</head><body>
<nav><h1>📚 ResearchPortal Staff</h1><span><?php echo $_SESSION['admin']; ?> | <a href="logout.php" style="color:#c9a84c">Logout</a></span></nav>
<div class="layout">
<aside class="sidebar">
  <div class="lbl">Documents</div>
  <a href="dashboard.php?doc=/etc/passwd">👥 /etc/passwd</a>
  <a href="dashboard.php?doc=/etc/hostname">🖥 Hostname</a>
  <a href="dashboard.php?doc=config.php">⚙️ Config (blocked)</a>
  <a href="dashboard.php?doc=/var/www/html/secure/.raw_key">🔑 Key (blocked)</a>
  <div class="lbl">Account</div>
  <a href="logout.php">🚪 Logout</a>
</aside>
<main class="main">
  <h2>Staff Dashboard</h2>
  <div class="card">
    <div class="flag-box">FLAG1{r3s34rch_p0rt4l_slug_sql1_0wn3d}</div>
  </div>
  <h2>Document Viewer</h2>
  <div class="card">
    <p style="font-size:0.8rem;color:#888;margin-bottom:0.8rem;">
      View server documents. Direct .php files and /secure/ directory are restricted.
    </p>
    <form method="GET">
      <input type="text" name="doc" value="<?php echo htmlspecialchars($_GET['doc'] ?? ''); ?>"
        placeholder="php://filter/convert.base64-encode/resource=config.php">
      <button>Read</button>
    </form>
    <div class="url-note">dashboard.php?doc=<?php echo htmlspecialchars($_GET['doc'] ?? ''); ?></div>
    <?php if($err): ?>
      <div class="err-msg">⚠ <?php echo $err; ?></div>
      <div class="hint">💡 PHP stream wrappers bypass path restrictions...</div>
    <?php endif; ?>
    <?php if($out): ?><pre><?php echo htmlspecialchars($out); ?></pre><?php endif; ?>
  </div>
</main>
</div>
</body></html>
