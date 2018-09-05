<?php
	class Team {
		public static function getName($id) {
			global $nitto_db, $nitto_error;
			if (!$id OR !$team = $nitto_db->fetch_row('nt_team', 'name', array('id' => intval($id)))) {
				$nitto_error;
				$team['name'] = '';
			}
			return $team['name'];
		}
	}
?>