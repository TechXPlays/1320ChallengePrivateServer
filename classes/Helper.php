<?php
	class Helper {
		// Password hashing algorithm
		public static function hashPassword($password) {
			return md5(md5($password));
		}
		
		// Generate a random password
		public static function randomPassword($length = 8) {
			$characters = array();
			for ($i = 0; $i < $length; $i++) {
				$distribution = mt_rand(1, 4);
				if ($distribution == 1) $characters []= chr(mt_rand(48, 57)); // Numerals
				elseif ($distribution == 4) $characters []= chr(mt_rand(65, 90)); // Uppercase
				else $characters []= chr(mt_rand(97, 122)); // Lowercase
				shuffle($characters);
			}
			shuffle($characters);
			return implode("", $characters);
		}
		
		// Generate random activation code
		public static function randomActivationCode($username, $length = 8) {
			$characters = array();
			for ($i = 0; $i < $length; $i++) {
				$distribution = mt_rand(1, 4);
				if ($distribution == 1) $characters []= chr(mt_rand(48, 57)); // Numerals
				elseif ($distribution == 4) $characters [] = strtoupper(substr(md5($username), mt_rand(0, 31), 1)); // Random
				else $characters []= chr(mt_rand(65, 90)); // Uppercase
				shuffle($characters);
			}
			shuffle($characters);
			return implode("", $characters);
		}
	}
?>