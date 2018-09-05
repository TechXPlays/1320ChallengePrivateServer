<?php
	class Mail {
		public static function send($subject, $email, $template, $variables) {
			$body = preg_replace("/\{([^\{]{1,100}?)\}/e", "\$variables['$1']", file_get_contents((TEMPLATE_DIR).$template.".tpl"));
			
			$headers = 'From: nitto@88.198.28.29' . "\r\n";
			return @mail($email, $subject, $body, $headers); // Throw an error next time around...
		}
	}
?>