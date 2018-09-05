<?php
	class Response {
		private $variables;
		
		public function setVariable($key, $value) {
			$this->variables[$key] = $value;
		}
		
		public function getVariable($key) {
			if (isset($this->variables[$key])) return $this->variables[$key];
			else return NULL;
		}
		
		public function toString($encode = true) {
			if (!$this->variables) return;
			$string = "";
			foreach ($this->variables AS $key=>$value)
				$string .= "&".$key."=".$value;
			// If encoding is required (default) encrypt the string before returning
			if ($encode) $string = "data=".$this->encode($string);
			return $string;
		}
		
		public static function encode($response_string) {
			$key = ENCRYPTION_KEY;
			$_encoded = "";
			// var_dump($response_string);
			// Simple XOR encryption to counteract the casual spoofer
			for ($i = 0; $i < strlen($response_string); $i++) {
				$char = chr(ord($response_string[$i]) ^ ord($key[$i%strlen($key)]));
				if (ord($char) == 0) $char = '~x00~';
				if (ord($char) == 37) $char = '~prc~';
				if (ord($char) == 38) $char = '~amp~';
				if (ord($char) == 43) $char = '~pls~';
				// echo "[".ord($response_string[$i])."] ".$response_string[$i]." ^ ".ord($key[$i%strlen($key)])."\n";
				// echo "    > ".(ord($response_string[$i]) ^ ord($key[$i%strlen($key)]))." [".chr(ord($response_string[$i]) ^ ord($key[$i%strlen($key)]))."]\n";
				$_encoded .= $char;
			}
			// var_dump($_encoded);
			return $_encoded;
		}
	}
?>