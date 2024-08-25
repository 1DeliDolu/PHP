<?php
defined('_IAD') or die();

// database-settings
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'mysql');
define('DB_USER', 'root');
define('DB_PASS', null);

// password requirements
define('PW_UPPERCASE', true);
define('PW_LOWERCASE', true);
define('PW_DIGIT', true);
define('PW_SYMBOL', true);
define('PW_MINLEN', 8);
define('PW_MAXLEN', 12);  // null for unlimited length or int gt PW_MINLEN