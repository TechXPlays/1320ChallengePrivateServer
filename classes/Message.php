<?php
	class Message {
		public static function getNewest($to_id) {
			global $nitto_db, $nitto_error;
			if (!$to_id OR !$message = $nitto_db->fetch_row('nt_message', NULL, array('to_id' => intval($to_id)))) {
				return false;
			}
			else return $message;
		}
	}
?>