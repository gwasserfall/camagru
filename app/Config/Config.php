<?php

// System folder locations
define("ROOT", dirname(__DIR__));
define("VIEWS", ROOT . "/Views/");
define("SNIPS", ROOT . "/Views/Snippets/");
define("TEMP",  ROOT . "/Temp/");
define("EMAIL_TEMPLATES", ROOT . "/EmailTemplates/");

// Database details (regenerated by setup.php)
define("DATABASE_URI", "127.0.0.1");
define("DATABASE_USER", "root");
define("DATABASE_PASS", "password");

// Password hashing salt (regenerated by setup.php)
define("SALT", "jI3fRxXV9DQvBTGKS0E7JiYh8me4dH");

// Used in email templates
define("SERVER_ADDRESS", "http://192.168.0.101:8000/");
define("ADMIN_EMAIL", "noreply@camagru.local");

// SameOrigin header
header('X-Frame-Options: SAMEORIGIN');