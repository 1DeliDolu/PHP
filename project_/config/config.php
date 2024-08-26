<?php
// database
define("DB_HOST", '127.0.0.1');
// define("DB_HOST", 'localhost');
define("DB_PORT", 3306);
define("DB_NAME", 'project');
define("DB_USER", 'user_project');  // alternatively, use 'root'
define("DB_PASS", 'Pa$$w0rd');      // alternatively, use ''
// define("DB_USER", 'root');  // alternatively, use 'root'
// define("DB_PASS", '');      // alternatively, use ''

// password settings
define("MIN_LENGTH", 8);            // minimum length > 0
define("MAX_LENGTH", 20);           // maximum length > MIN_LENGTH or false
define("UCASE", true);              // true or false; uppercase letters required
define("LCASE", true);              // true or false; lowercase letters required
define("DIGIT", true);              // true or false; digit required
define("SYMBOL", true);             // true or false; symbol required

// timezone settings
define("TIMEZONE", 'Europe/Berlin');

// paths
define("SESSION_PATH", '/tmp');

// time auto hide alerts
define("ALERT_AUTO_HIDE", 30);