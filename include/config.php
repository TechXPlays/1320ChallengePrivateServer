<?php
	// PHP error reporting
	ini_set('display_errors', 'On');
	
	// Database settings
	define('DB_HOST', 'localhost');
	define('DB_USER', 'nitto');
	define('DB_PASS', '!@#*cn_xm');
	define('DB_NAME', 'nitto');
	
	// Error reporting settings
	// The following errors are valid
		// 0 - no error reporting
		// 1 - log errors into logfile
		// 2 - send e-mail notifications
		// 4 - generate as response
		// (combine with logical OR)
	define('ERROR_LOG_LEVEL', (1 | 2 | 4));
	define('ERROR_LOG_FILE', 'nitto_error.log');
	define('ERROR_LOG_EMAIL', 'admin@localhost');
	
	// Registration birthyear limits
	define('BIRTHYEAR_MAX', '2000');
	define('BIRTHYEAR_MIN', '1900');
	
	// E-mail template directory
	define('TEMPLATE_DIR', 'templates/');
	
	// The encryption key used in decoding all communication between game and server
	define('ENCRYPTION_KEY', 'z1A#7z24x_8!a');
	// The password salt used in the hashing of passwords for more secure storage
	define('PASSWORD_SALT', '11z#$*@kzx_#2');
	
	// Current latest version that is available
	define('CURRENT_VERSION', '0.1');
	// The minimum version required to communicate with server
	define('MIN_VERSION_REQUIRED', '0.1');
	
	// Allow signup and maintenance
	define('ALLOW_SIGNUP', true);	
	define ('SERVER_MAINTENANCE', false);
	
	// Default Mopar Drag Car exists
	define('MOPAR_DEFAULT', "1");
	
	// Starting balance
	define('STARTING_BALANCE', 1000);
?>