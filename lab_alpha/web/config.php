<?php
// TravelHub Configuration File
// DO NOT EXPOSE THIS FILE

define('DB_HOST', 'examprep_alpha_db');
define('DB_USER', 'root');
define('DB_PASS', 'rootpass');
define('DB_NAME', 'travelhub_db');

define('SSH_USER', 'traveler');
define('SSH_KEY_PATH', '/var/www/html/storage/keys/.traveler_id');

// FLAG2 — found via LFI
// FLAG2{c0nf1g_LF1_expos3d_tr4v3lhub}

define('APP_SECRET', 'xK9#mP2$vL5nQ8');
define('UPLOAD_DIR', '/var/www/html/uploads/');
?>
