<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }
$conn = new mysqli('examprep_delta_db','root','rootpass','cloudstore_db');

// SQLi in file search
$files = [];
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    // VULNERABLE
    $sql = "SELECT id,filename,owner,size_kb,file_type,uploaded_at FROM files_meta_j9 WHERE file_type='$type'";
    $res = $conn->query($sql);
    if ($res) while($r=$res->fetch_assoc()) $files[] = $r;
} else {
    $res = $conn->query("SELECT * FROM files_meta_j9");
    while($r=$res->fetch_assoc()) $files[] = $r;
}

// LFI in page param
$out='';
if (isset($_GET['page'])) {
    $p=$_GET['page'];
    if(file_exists($p)) $out=file_get_contents($p);
    else $out="Not found: ".htmlspecialchars($p);
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>CloudStore Dashboard</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#f4f0ff;}nav{background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:0.8rem 2rem;display:flex;justify-content:space-between;align-items:center;}nav h1{font-size:1rem;}nav span{font-size:0.78rem;opacity:0.85;}.layout{display:grid;grid-template-columns:200px 1fr;min-height:calc(100vh - 46px);}.sidebar{background:#5a67d8;padding:1rem 0;}.sidebar a{display:block;color:#c3dafe;text-decoration:none;padding:0.65rem 1.2rem;font-size:0.8rem;}.sidebar a:hover{background:#4c51bf;color:white;}.sidebar .lbl{font-size:0.62rem;color:#a3bffa;padding:0.8rem 1.2rem 0.3rem;text-transform:uppercase;letter-spacing:0.08em;}.main{padding:1.5rem;}h2{font-size:1rem;color:#5a67d8;margin-bottom:1rem;padding-bottom:0.4rem;border-bottom:2px solid #c3dafe;}.card{background:white;border-radius:8px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin-bottom:1.5rem;}.flag-box{background:#0a1a0a;color:#00ff88;font-family:monospace;padding:0.8rem;border-radius:6px;text-align:center;margin-bottom:1rem;}table{width:100%;border-collapse:collapse;font-size:0.8rem;}th{background:#5a67d8;color:white;padding:7px 10px;text-align:left;font-weight:500;}td{padding:7px 10px;border-bottom:1px solid #f0f0f0;}input[type=text]{padding:7px 12px;border:1.5px solid #ddd;border-radius:6px;font-size:0.8rem;font-family:monospace;width:70%;}button{padding:7px 14px;background:#667eea;color:white;border:none;border-radius:6px;cursor:pointer;margin-left:6px;}pre{background:#1a1a2e;color:#a3bffa;font-family:monospace;font-size:0.73rem;padding:1rem;border-radius:6px;white-space:pre-wrap;max-height:300px;overflow-y:auto;margin-top:0.8rem;word-break:break-all;}.url-note{font-size:0.67rem;color:#aaa;font-family:monospace;margin-top:4px;}</style>
</head><body>
<nav><h1>☁️ CloudStore</h1><span><?php echo $_SESSION['admin']; ?> (<?php echo $_SESSION['role']; ?>) | <a href="logout.php" style="color:white">Logout</a></span></nav>
<div class="layout">
<aside class="sidebar">
  <div class="lbl">Files</div>
  <a href="dashboard.php?type=PDF">📄 PDFs</a>
  <a href="dashboard.php?type=Archive">📦 Archives</a>
  <a href="dashboard.php?type=Log">📋 Logs</a>
  <div class="lbl">System</div>
  <a href="dashboard.php?page=index.php">📄 View index.php</a>
  <a href="dashboard.php?page=/etc/passwd">👥 /etc/passwd</a>
  <a href="dashboard.php?page=/etc/hosts">🌐 Hosts</a>
  <div class="lbl">Account</div>
  <a href="logout.php">🚪 Logout</a>
</aside>
<main class="main">
  <h2>Dashboard</h2>
  <div class="card">
    <div class="flag-box">FLAG1{cl0udst0r3_AND_br4ck3t_byp4ss_0wn3d}</div>
  </div>

  <h2>File Search</h2>
  <div class="card">
    <form method="GET">
      <input type="text" name="type" value="<?php echo htmlspecialchars($_GET['type'] ?? ''); ?>" placeholder="PDF / Archive / Log / Document">
      <button>Search</button>
    </form>
    <div class="url-note">dashboard.php?type=<?php echo htmlspecialchars($_GET['type'] ?? ''); ?></div>
    <?php if($files): ?>
    <table style="margin-top:1rem;">
      <tr><th>ID</th><th>Filename</th><th>Owner</th><th>Size</th><th>Type</th><th>Uploaded</th></tr>
      <?php foreach($files as $f): ?>
      <tr><td><?php echo $f['id'];?></td><td><?php echo $f['filename'];?></td><td><?php echo $f['owner'];?></td><td><?php echo $f['size_kb'];?>KB</td><td><?php echo $f['file_type'];?></td><td><?php echo $f['uploaded_at'];?></td></tr>
      <?php endforeach; ?>
    </table>
    <?php endif; ?>
  </div>

  <h2>System File Viewer</h2>
  <div class="card">
    <form method="GET">
      <input type="text" name="page" value="<?php echo htmlspecialchars($_GET['page'] ?? ''); ?>" placeholder="index.php or /etc/passwd or /var/www/html/.hidden/.sk_rsa">
      <button>Read</button>
    </form>
    <div class="url-note">dashboard.php?page=<?php echo htmlspecialchars($_GET['page'] ?? ''); ?></div>
    <?php if($out): ?><pre><?php echo htmlspecialchars($out); ?></pre><?php endif; ?>
  </div>
</main>
</div>
</body></html>
