<?php
session_start(); $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $conn=new mysqli('examprep_gamma_db','root','rootpass','foodorder_db');
    $u=$_POST['u'];$p=$_POST['p'];
    $r=$conn->query("SELECT * FROM admin_accounts_w2 WHERE username='$u' AND password='$p'");
    if($r&&$r->num_rows>0){$row=$r->fetch_assoc();$_SESSION['admin']=$row['username'];header("Location: dashboard.php");exit;}
    else{$error="Wrong credentials.";}
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>QuickBite Admin</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#c0392b;min-height:100vh;display:flex;align-items:center;justify-content:center;}.card{background:white;border-radius:12px;padding:2.5rem;width:360px;}.card h2{color:#e74c3c;text-align:center;margin-bottom:1.5rem;}label{font-size:0.78rem;color:#555;font-weight:600;display:block;margin-bottom:4px;}input{width:100%;padding:9px 12px;border:1.5px solid #ddd;border-radius:6px;font-size:0.88rem;margin-bottom:1rem;}button{width:100%;padding:11px;background:#e74c3c;color:white;border:none;border-radius:6px;font-size:0.9rem;cursor:pointer;}.err{background:#fdecea;color:#c0392b;padding:9px;border-radius:5px;font-size:0.78rem;margin-bottom:1rem;}</style>
</head><body><div class="card"><h2>🍜 QuickBite Admin</h2>
<?php if($error): ?><div class="err"><?php echo $error; ?></div><?php endif; ?>
<form method="POST"><label>Username</label><input name="u" type="text"><label>Password</label><input name="p" type="password"><button>Login</button></form></div></body></html>
