<?php
// CloudStore — Main entry
// DB CONFIG EMBEDDED (readable via LFI)
$db_host = 'examprep_delta_db';
$db_user = 'root';
$db_pass = 'rootpass';
$db_name = 'cloudstore_db';

session_start(); $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $conn=new mysqli($db_host,$db_user,$db_pass,$db_name);
    if($conn->connect_error) die("DB starting... refresh in 15s.");
    $u=$_POST['u'];$p=$_POST['p'];
    // VULNERABLE - AND bracket bypass: ') OR ('1'='1
    $sql="SELECT * FROM system_users_b4 WHERE (username='$u') AND (password='$p')";
    $r=$conn->query($sql);
    if($r&&$r->num_rows>0){$row=$r->fetch_assoc();$_SESSION['admin']=$row['username'];$_SESSION['role']=$row['role'];header("Location: dashboard.php");exit;}
    else{$error="Login failed.";}
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>CloudStore</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#667eea,#764ba2);min-height:100vh;display:flex;align-items:center;justify-content:center;}.card{background:white;border-radius:14px;padding:2.5rem;width:380px;box-shadow:0 20px 60px rgba(0,0,0,0.3);}.logo{text-align:center;margin-bottom:2rem;}.logo h1{font-size:1.6rem;color:#667eea;}.logo p{color:#888;font-size:0.78rem;}label{font-size:0.78rem;color:#555;font-weight:600;display:block;margin-bottom:4px;}input{width:100%;padding:9px 12px;border:1.5px solid #ddd;border-radius:7px;font-size:0.88rem;margin-bottom:1rem;}button{width:100%;padding:11px;background:linear-gradient(135deg,#667eea,#764ba2);color:white;border:none;border-radius:7px;font-size:0.9rem;cursor:pointer;}.err{background:#fdecea;color:#c0392b;padding:9px;border-radius:5px;font-size:0.78rem;margin-bottom:1rem;}</style>
</head><body><div class="card"><div class="logo"><h1>☁️ CloudStore</h1><p>Secure File Management Platform</p></div>
<?php if($error): ?><div class="err"><?php echo $error; ?></div><?php endif; ?>
<form method="POST"><label>Username</label><input name="u" type="text" placeholder="username"><label>Password</label><input name="p" type="password" placeholder="••••••••"><button>Sign In</button></form></div></body></html>
