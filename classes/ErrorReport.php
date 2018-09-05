<?php
	class ErrorReport {
		private $level;
		private $log_file;
		private $log_email;

		public function __construct($level, $log_file, $log_email) {
			$this->level = $level;
			$this->log_file = $log_file;
			$this->log_email = $log_email;
		}
		
		public function report($function, $error_number, $error_detail = NULL, $fatal = false) {
			echo "<pre>";
			echo ('Error in function: '.$function);
			echo ('Error number: '.$error_number);
			echo ('Error detail: '.$error_detail);
			echo "</pre>";
			if ($fatal) die('<b>Fatal Error</b>');
		}
	}
?>