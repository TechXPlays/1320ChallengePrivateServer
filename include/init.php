<?php
	// Autoload classes from the classes directory
	function __autoload($class_name) {
		include 'classes/'.$class_name . '.php';
	}
	
	// Instantiate an error report object that can be used globablly
	$nitto_error = new ErrorReport(ERROR_LOG_LEVEL, ERROR_LOG_FILE, ERROR_LOG_EMAIL);
	
	// Instantiate a database object that can be used globally
	$nitto_db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>
