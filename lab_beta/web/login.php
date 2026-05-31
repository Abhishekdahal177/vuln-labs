<?php
session_start(); $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $conn=new mysqli('examprep_beta_db','root','rootpass','auction_db');
    $u=$_POST['u'];$p=$_POST['p'];
    $r=$conn->query("SELECT * FROM site_admins_p7 WHERE login_name='$u' AND login_pass='$p'");
    if($r&&$r->num_rows>0){$row=$r->fetch_assoc();$_SESSION['admin']=$row['login_name'];header("Location: dashboard.php");exit;}
    else{$error="Invalid credentials.";}
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>BidZone Admin</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#1a1a2e;min-height:100vh;display:flex;align-items:center;justify-content:center;}.card{background:#16213e;border:1px solid #e94560;border-radius:12px;padding:2.5rem;width:350px;}.card h2{color:#e94560;text-align:center;margin-bottom:1.5rem;}label{font-size:0.78rem;color:#a8b2d8;display:block;margin-bottom:4px;}input{width:100%;padding:9px 12px;background:#0d0d1a;border:1px solid #2a2a4a;border-radius:6px;color:#e8e8f0;font-size:0.88rem;margin-bottom:1rem;}button{width:100%;padding:10px;background:#e94560;color:white;border:none;border-radius:6px;cursor:pointer;}.err{background:#3d1010;color:#e94560;padding:8px;border-radius:5px;font-size:0.78rem;margin-bottom:1rem;}</style>
</head><body><div class="card"><h2>🔨 BidZone Admin</h2>
<?php if($error): ?><div class="err"><?php echo $error; ?></div><?php endif; ?>
<form method="POST"><label>Username</label><input name="u" type="text"><label>Password</label><input name="p" type="password"><button>Login</button></form></div></body></html>
