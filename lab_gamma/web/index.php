<?php
$conn = new mysqli('examprep_gamma_db', 'root', 'rootpass', 'foodorder_db');
if ($conn->connect_error) die("Starting... refresh in 15s.");
$cat = $_GET['cat'] ?? 'Nepali';
// VULNERABLE string injection
$sql = "SELECT id, name, category, price, calories, available FROM menu_items_q6 WHERE category='$cat'";
$result = $conn->query($sql);
$cats = $conn->query("SELECT DISTINCT category FROM menu_items_q6");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>QuickBite — Menu</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#fff9f0;color:#2d1810;}header{background:#e74c3c;color:white;padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;}header h1{font-size:1.3rem;}header nav a{color:#ffcccc;text-decoration:none;margin-left:1.5rem;font-size:0.82rem;}.cats{background:#c0392b;padding:0.6rem 2rem;display:flex;gap:0.8rem;flex-wrap:wrap;}.cats a{padding:4px 14px;border-radius:20px;text-decoration:none;font-size:0.78rem;background:rgba(255,255,255,0.15);color:white;}.cats a:hover,.cats a.active{background:white;color:#c0392b;}.container{max-width:900px;margin:2rem auto;padding:0 1rem;}.url-bar{font-family:monospace;font-size:0.72rem;background:#fff3e0;border:1px solid #ffcc80;padding:6px 12px;border-radius:5px;margin-bottom:1.5rem;color:#555;}.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;}.item{background:white;border-radius:10px;padding:1.2rem;box-shadow:0 2px 6px rgba(0,0,0,0.08);border-top:3px solid #e74c3c;}.item h3{font-size:0.95rem;margin-bottom:4px;}.item .cat{font-size:0.72rem;color:#888;margin-bottom:8px;}.item .price{font-size:1.1rem;font-weight:700;color:#e74c3c;}.item .cal{font-size:0.72rem;color:#aaa;margin-top:4px;}.no-result{color:#e74c3c;font-style:italic;}</style>
</head><body>
<header><h1>🍜 QuickBite</h1><nav><a href="index.php">Menu</a><a href="login.php">Admin</a></nav></header>
<div class="cats">
<?php while($c=$cats->fetch_assoc()): ?>
<a href="index.php?cat=<?php echo urlencode($c['category']); ?>" <?php if($c['category']==$cat) echo 'class="active"'; ?>><?php echo $c['category']; ?></a>
<?php endwhile; ?>
</div>
<div class="container">
  <div class="url-bar">GET /index.php?cat=<?php echo htmlspecialchars($cat); ?></div>
  <div class="grid">
  <?php if($result&&$result->num_rows>0): while($r=$result->fetch_assoc()): ?>
  <div class="item"><h3><?php echo $r['name']; ?></h3><div class="cat"><?php echo $r['category']; ?></div><div class="price">Rs. <?php echo $r['price']; ?></div><div class="cal"><?php echo $r['calories']; ?> kcal</div></div>
  <?php endwhile; else: ?><p class="no-result">No items found: <?php echo htmlspecialchars($cat); ?></p><?php endif; ?>
  </div>
</div>
</body></html>
