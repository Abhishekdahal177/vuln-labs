<?php
$conn = new mysqli('examprep_beta_db', 'root', 'rootpass', 'auction_db');
if ($conn->connect_error) die("Starting up... refresh in 15s.");
$id = $_GET['id'] ?? '1';
// VULNERABLE integer injection — 7 columns
$sql = "SELECT id, title, seller, starting_bid, current_bid, ends_in, category FROM auction_items_k3 WHERE id=$id";
$result = $conn->query($sql);
$all = $conn->query("SELECT id, title, current_bid, ends_in FROM auction_items_k3");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>BidZone Auctions</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Segoe UI',sans-serif;background:#1a1a2e;color:#e8e8f0;}header{background:#16213e;padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid #e94560;}header h1{color:#e94560;font-size:1.3rem;}header nav a{color:#a8b2d8;text-decoration:none;margin-left:1.5rem;font-size:0.82rem;}.container{max-width:900px;margin:2rem auto;padding:0 1rem;display:grid;grid-template-columns:1fr 280px;gap:1.5rem;}.url-bar{font-family:monospace;font-size:0.72rem;background:#0d0d1a;border:1px solid #e94560;padding:6px 12px;border-radius:5px;margin-bottom:1.5rem;color:#a8b2d8;grid-column:1/-1;}.item-card{background:#16213e;border-radius:10px;padding:1.5rem;border:1px solid #2a2a4a;}.item-card h2{color:#e94560;font-size:1.2rem;margin-bottom:0.5rem;}.item-card .meta{font-size:0.78rem;color:#6b6b85;margin-bottom:1rem;}.bid-box{background:#0d0d1a;border-radius:8px;padding:1rem;margin-top:1rem;}.bid-box .current{font-size:1.6rem;font-weight:700;color:#00ff88;}.bid-box .timer{font-size:0.78rem;color:#a8b2d8;margin-top:4px;}.sidebar h3{color:#a8b2d8;font-size:0.85rem;margin-bottom:1rem;border-bottom:1px solid #2a2a4a;padding-bottom:0.5rem;}.lot-item{padding:0.6rem 0;border-bottom:1px solid #2a2a4a;}.lot-item a{color:#a8b2d8;text-decoration:none;font-size:0.82rem;}.lot-item a:hover{color:#e94560;}.lot-price{font-size:0.78rem;color:#00ff88;margin-top:2px;}.no-result{color:#e94560;}</style>
</head><body>
<header><h1>🔨 BidZone</h1><nav><a href="index.php?id=1">Lots</a><a href="login.php">Admin</a></nav></header>
<div class="container">
  <div class="url-bar">GET /index.php?id=<?php echo htmlspecialchars($id); ?></div>
  <main>
    <?php if ($result && $result->num_rows > 0): while($r=$result->fetch_assoc()): ?>
    <div class="item-card">
      <h2><?php echo $r['title']; ?></h2>
      <div class="meta">Seller: <?php echo $r['seller']; ?> &nbsp;·&nbsp; Category: <?php echo $r['category']; ?></div>
      <div class="bid-box">
        <div class="current">$<?php echo $r['current_bid']; ?></div>
        <div class="timer">⏱ Ends in: <?php echo $r['ends_in']; ?></div>
        <div style="font-size:0.75rem;color:#6b6b85;margin-top:4px;">Starting bid: $<?php echo $r['starting_bid']; ?></div>
      </div>
    </div>
    <?php endwhile; else: ?><p class="no-result">Lot not found for id=<?php echo htmlspecialchars($id); ?></p><?php endif; ?>
  </main>
  <aside>
    <h3>Active Lots</h3>
    <?php while($l=$all->fetch_assoc()): ?>
    <div class="lot-item"><a href="index.php?id=<?php echo $l['id']; ?>"><?php echo $l['title']; ?></a><div class="lot-price">$<?php echo $l['current_bid']; ?> · <?php echo $l['ends_in']; ?></div></div>
    <?php endwhile; ?>
  </aside>
</div>
</body></html>
