<?php
	class Version {
		// Check if the version is less than the minimum version supported by the server
		public static function versionRequired($version) {
			if (floatval($version) < MIN_VERSION_REQUIRED) return true;
			else return false;
		}
		
		// Check if the current version is the newest available
		public static function newVersionAvailable($version) {
			if (floatval($version) < CURRENT_VERSION) return true;
			else return false;
		}
	}
?>