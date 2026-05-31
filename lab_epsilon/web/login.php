<?php
session_start(); $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $conn=new mysqli('examprep_epsilon_db','root','rootpass','research_db');
    $u=$_POST['u'];$p=$_POST['p'];
    $r=$conn->query("SELECT * FROM portal_staff_x3 WHERE staff_name='$u' AND access_code='$p'");
    if($r&&$r->num_rows>0){$row=$r->fetch_assoc();$_SESSION['admin']=$row['staff_name'];header("Location: dashboard.php");exit;}
    else{$error="Access denied.";}
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>ResearchPortal Staff</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#2c2416;min-height:100vh;display:flex;align-items:center;justify-content:center;}.card{background:#f8f5f0;border-radius:12px;padding:2.5rem;width:370px;}.card h2{color:#2c2416;text-align:center;margin-bottom:1.5rem;font-family:Georgia,serif;}label{font-size:0.78rem;color:#555;font-weight:600;display:block;margin-bottom:4px;}input{width:100%;padding:9px 12px;border:1.5px solid #d5c9b0;border-radius:6px;font-size:0.88rem;margin-bottom:1rem;}button{width:100%;padding:11px;background:#2c2416;color:#f5e6c8;border:none;border-radius:6px;font-size:0.9rem;cursor:pointer;}.err{background:#fdecea;color:#c0392b;padding:9px;border-radius:5px;font-size:0.78rem;margin-bottom:1rem;}</style>
</head><body><div class="card"><h2>📚 Staff Access</h2>
<?php if($error): ?><div class="err"><?php echo $error; ?></div><?php endif; ?>
<form method="POST"><label>Staff Name</label><input name="u" type="text"><label>Access Code</label><input name="p" type="password"><button>Access Portal</button></form></div></body></html>
