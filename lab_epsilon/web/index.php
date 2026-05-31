<?php
$conn = new mysqli('examprep_epsilon_db','root','rootpass','research_db');
if ($conn->connect_error) die("Starting... refresh in 15s.");
$slug = $_GET['slug'] ?? 'ai-security-2025';
// VULNERABLE string injection via slug
$sql = "SELECT id, slug, title, author, abstract, field, year FROM papers_n5k WHERE slug='$slug'";
$result = $conn->query($sql);
$all = $conn->query("SELECT slug, title, field, year FROM papers_n5k");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>ResearchPortal — Papers</title>
<style>*{margin:0;padding:0;box-sizing:border-box;}body{font-family:Georgia,serif;background:#f8f5f0;color:#2c2416;}header{background:#2c2416;color:#f5e6c8;padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;}header h1{font-size:1.2rem;letter-spacing:0.5px;}header nav a{color:#c9a84c;text-decoration:none;margin-left:1.5rem;font-size:0.82rem;font-family:'Segoe UI',sans-serif;}.container{max-width:900px;margin:2rem auto;padding:0 1rem;display:grid;grid-template-columns:2fr 1fr;gap:2rem;}.url-bar{font-family:monospace;font-size:0.72rem;background:#fff8e1;border:1px solid #f5c842;padding:6px 12px;border-radius:5px;margin-bottom:1.5rem;color:#555;grid-column:1/-1;}.paper h2{font-size:1.3rem;line-height:1.3;margin-bottom:0.5rem;}.meta{font-size:0.78rem;color:#888;font-family:'Segoe UI',sans-serif;margin-bottom:1rem;border-bottom:1px solid #e0d5c0;padding-bottom:0.8rem;}.abstract{line-height:1.8;font-size:0.95rem;}.sidebar h3{font-family:'Segoe UI',sans-serif;font-size:0.78rem;text-transform:uppercase;letter-spacing:0.08em;color:#c9a84c;border-bottom:2px solid #c9a84c;padding-bottom:0.3rem;margin-bottom:1rem;}.paper-list{list-style:none;}.paper-list li{margin-bottom:0.8rem;padding-bottom:0.8rem;border-bottom:1px solid #e0d5c0;}.paper-list a{color:#2c2416;text-decoration:none;font-size:0.85rem;font-family:'Segoe UI',sans-serif;}.paper-list a:hover{color:#c9a84c;}.paper-list .field{font-size:0.7rem;color:#aaa;font-family:'Segoe UI',sans-serif;margin-top:2px;}.no-result{color:#c0392b;font-style:italic;font-family:'Segoe UI',sans-serif;}</style>
</head><body>
<header><h1>📚 ResearchPortal</h1><nav style="font-family:'Segoe UI',sans-serif;"><a href="index.php">Papers</a><a href="login.php">Staff Login</a></nav></header>
<div class="container">
  <div class="url-bar">GET /index.php?slug=<?php echo htmlspecialchars($slug); ?></div>
  <main class="paper">
    <?php if($result&&$result->num_rows>0): while($r=$result->fetch_assoc()): ?>
    <h2><?php echo $r['title']; ?></h2>
    <div class="meta">By <?php echo $r['author']; ?> &nbsp;·&nbsp; <?php echo $r['field']; ?> &nbsp;·&nbsp; <?php echo $r['year']; ?></div>
    <div class="abstract"><?php echo $r['abstract']; ?></div>
    <?php endwhile; else: ?>
    <p class="no-result">Paper not found: <?php echo htmlspecialchars($slug); ?></p>
    <?php endif; ?>
  </main>
  <aside>
    <h3>All Papers</h3>
    <ul class="paper-list">
      <?php while($p=$all->fetch_assoc()): ?>
      <li><a href="index.php?slug=<?php echo urlencode($p['slug']); ?>"><?php echo $p['title']; ?></a><div class="field"><?php echo $p['field']; ?> · <?php echo $p['year']; ?></div></li>
      <?php endwhile; ?>
    </ul>
  </aside>
</div>
</body></html>
