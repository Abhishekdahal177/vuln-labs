<?php
$conn = new mysqli('examprep_alpha_db', 'root', 'rootpass', 'travelhub_db');
if ($conn->connect_error) die("Connecting... refresh in 15s.");

$category = $_GET['cat'] ?? 'Adventure';
// VULNERABLE: string injection via cat param
$sql = "SELECT id, slug, name, country, category, price, rating, description FROM destinations_r4x WHERE category='$category'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>TravelHub — Explore</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',sans-serif;background:#f0f7ff;color:#1a2035;}
header{background:linear-gradient(135deg,#1a6bb5,#0d3b6e);color:white;padding:1.2rem 2rem;display:flex;justify-content:space-between;align-items:center;}
header h1{font-size:1.4rem;letter-spacing:-0.3px;}
header nav a{color:#a8d4ff;text-decoration:none;margin-left:1.5rem;font-size:0.82rem;}
header nav a:hover{color:white;}
.filter-bar{background:white;padding:0.8rem 2rem;border-bottom:1px solid #dde5f0;display:flex;gap:0.8rem;flex-wrap:wrap;align-items:center;}
.filter-bar a{padding:5px 14px;border-radius:20px;text-decoration:none;font-size:0.78rem;border:1px solid #1a6bb5;color:#1a6bb5;}
.filter-bar a:hover,.filter-bar a.active{background:#1a6bb5;color:white;}
.container{max-width:960px;margin:2rem auto;padding:0 1rem;}
.url-bar{font-family:monospace;font-size:0.72rem;background:#fffde7;border:1px solid #fdd835;padding:6px 12px;border-radius:5px;margin-bottom:1.5rem;color:#555;}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.2rem;}
.card{background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.07);}
.card-img{height:120px;background:linear-gradient(135deg,#1a6bb5,#0d3b6e);display:flex;align-items:center;justify-content:center;font-size:2rem;}
.card-body{padding:1rem;}
.card-body h3{font-size:0.95rem;margin-bottom:4px;}
.card-body .country{font-size:0.72rem;color:#888;margin-bottom:6px;}
.card-body .price{font-size:1.1rem;font-weight:700;color:#1a6bb5;}
.card-body .rating{font-size:0.75rem;color:#f39c12;margin-top:4px;}
.no-result{color:#e74c3c;font-style:italic;padding:1rem 0;}
.login-link{text-align:right;margin-bottom:1rem;}
.login-link a{font-size:0.8rem;color:#1a6bb5;}
</style>
</head>
<body>
<header>
  <h1>✈️ TravelHub</h1>
  <nav>
    <a href="index.php?cat=City">City</a>
    <a href="index.php?cat=Beach">Beach</a>
    <a href="index.php?cat=Adventure">Adventure</a>
    <a href="login.php">Admin</a>
  </nav>
</header>
<div class="filter-bar">
  <strong style="font-size:0.8rem;">Category:</strong>
  <?php foreach(['City','Beach','Adventure'] as $c): ?>
  <a href="index.php?cat=<?php echo urlencode($c); ?>" <?php if($c==$category) echo 'class="active"'; ?>><?php echo $c; ?></a>
  <?php endforeach; ?>
</div>
<div class="container">
  <div class="url-bar">GET /index.php?cat=<?php echo htmlspecialchars($category); ?></div>
  <div class="grid">
  <?php
  $icons = ['City'=>'🏙️','Beach'=>'🏖️','Adventure'=>'🏔️','France'=>'🗼','Indonesia'=>'🌴','Nepal'=>'⛰️','Japan'=>'🗻'];
  if ($result && $result->num_rows > 0):
    while($r=$result->fetch_assoc()):
  ?>
    <div class="card">
      <div class="card-img"><?php echo $icons[$r['country']] ?? '🌍'; ?></div>
      <div class="card-body">
        <h3><?php echo $r['name']; ?></h3>
        <div class="country"><?php echo $r['country']; ?> · <?php echo $r['category']; ?></div>
        <div class="price">$<?php echo $r['price']; ?></div>
        <div class="rating">★ <?php echo $r['rating']; ?></div>
      </div>
    </div>
  <?php endwhile; else: ?>
    <p class="no-result">No destinations found for: <?php echo htmlspecialchars($category); ?></p>
  <?php endif; ?>
  </div>
</div>
</body>
</html>
