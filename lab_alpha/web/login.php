<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('examprep_alpha_db', 'root', 'rootpass', 'travelhub_db');
    $u = $_POST['u']; $p = $_POST['p'];
    $r = $conn->query("SELECT * FROM portal_admins_v2 WHERE uname='$u' AND passwd='$p'");
    if ($r && $r->num_rows > 0) {
        $row = $r->fetch_assoc();
        $_SESSION['admin'] = $row['uname'];
        header("Location: dashboard.php"); exit;
    } else { $error = "Invalid credentials."; }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>TravelHub Admin</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#0d3b6e;min-height:100vh;display:flex;align-items:center;justify-content:center;}.card{background:white;border-radius:12px;padding:2.5rem;width:360px;}.card h2{color:#1a6bb5;margin-bottom:1.5rem;text-align:center;}label{font-size:0.78rem;color:#555;font-weight:600;display:block;margin-bottom:4px;}input{width:100%;padding:9px 12px;border:1.5px solid #ddd;border-radius:6px;font-size:0.88rem;margin-bottom:1rem;}button{width:100%;padding:11px;background:#1a6bb5;color:white;border:none;border-radius:6px;font-size:0.9rem;cursor:pointer;}.err{background:#fdecea;color:#c0392b;padding:9px;border-radius:5px;font-size:0.78rem;margin-bottom:1rem;}</style>
</head><body><div class="card"><h2>✈️ Admin Login</h2>
<?php if($error): ?><div class="err"><?php echo $error; ?></div><?php endif; ?>
<form method="POST"><label>Username</label><input name="u" type="text"><label>Password</label><input name="p" type="password"><button>Login</button></form></div></body></html>
