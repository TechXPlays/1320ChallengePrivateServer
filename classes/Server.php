<?php
	class Server {
		public static function HELO($version, &$response) {
			$server_status = self::status();
			
			$response->setVariable('allowSignUp', $server_status['allow_sign_up']);
			$response->setVariable('versionOld', Version::newVersionAvailable($version) ? "1" : "0");
			$response->setVariable('versionRequired', Version::versionRequired($version) ? "1" : "0");
			$response->setVariable('maintenance', $server_status['maintenance']);
			$response->setVariable('sessionKey', session_id());
		}
		
		public static function status() {
			$status['traffic'] = false;
			$status['allow_sign_up'] = ALLOW_SIGNUP ? "1" : "0";;
			$status['maintenance'] = SERVER_MAINTENANCE ? "1" : "0";
			
			return $status;
		}
	}
?>