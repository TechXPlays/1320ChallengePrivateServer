<?php
	class Database {
		public function __construct($host, $user, $pass, $name) {
			global $nitto_error;
			// Try to connect and report any errors, these are fatal
			if (!mysql_connect($host, $user, $pass, $name))
				$nitto_error->report('mysql', mysql_errno(), mysql_error(), true);
			if (!mysql_select_db($name))
				$nitto_error->report('mysql', mysql_errno(), mysql_error(), true);
		}
		
		public function insert($table, $fieldvalues) {
			global $nitto_error;
			$escaped_fieldvalues = array();
			foreach ($fieldvalues as $field => $value) {
				$escaped_fieldvalues[$this->escape($field)] = $this->escape($value);
			}
			$fieldvalues = $escaped_fieldvalues;
			// Form the query
			$sql = "INSERT INTO `{$table}` SET";
			foreach ($fieldvalues as $field => $value)
				$sql .= " `{$field}` = '{$value}',";
			$sql[strlen($sql)-1] = "\0";
			// Query the database
			if (!$result = mysql_query($sql)) $nitto_error->report('mysql', mysql_errno(), mysql_error(), true);
			return mysql_insert_id();
		}
		
		public function update($table, $fieldvalues, $where) {
			global $nitto_error;
			$escaped_fieldvalues = array();
			foreach ($fieldvalues as $field => $value) {
				$escaped_fieldvalues[$this->escape($field)] = $this->escape($value);
			}
			$fieldvalues = $escaped_fieldvalues;
			$escaped_fieldvalues = array();
			foreach ($where as $field => $value) {
				$escaped_fieldvalues[$this->escape($field)] = $this->escape($value);
			}
			$where = $escaped_fieldvalues;
			// Form the query
			$sql = "UPDATE `{$table}` SET";
			foreach ($fieldvalues as $field => $value)
				$sql .= " `{$field}` = '{$value}',";
			$sql = substr($sql, 0, -1);
			if ($where) {
				$sql .= " WHERE";
				foreach ($where as $field => $value)
					$sql .= " `{$field}` = '{$value}' AND";
				$sql = substr($sql, 0, -4);
			}

			// Query the database
			if (!$result = mysql_query($sql)) $nitto_error->report('mysql', mysql_errno(), mysql_error(), false);
			return $result;
		}
		
		public function fetch_rows($table, $fields = NULL, $where = NULL, $order = NULL, $way = NULL, $limit = NULL) {
			global $nitto_error;
			// Do some escaping to combat SQL injection
			if ($order) $this->escape($order);
			if ($limit) $this->escape($limit);
			if ($fields) {
				if (is_string($fields)) $fields = array($fields);
				$escaped_fieldvalues = array();
				foreach ($fields as $field) {
					$escaped_fieldvalues []= $this->escape($field);
				}
				$fields = $escaped_fieldvalues;
			} else $fields = array('*');
			if ($where) {
				$escaped_fieldvalues = array();
				foreach ($where as $field => $value) {
					$escaped_fieldvalues[$this->escape($field)] = $this->escape($value);
				}
				$where = $escaped_fieldvalues;
			}
			
			// Form the query
			$sql = "SELECT";
			foreach ($fields as $field)
				$sql .= ' `'.$field.'`,';
			$sql = str_replace('`*`', '*', $sql);
			$sql = substr($sql, 0, -1); // Remove the last comma
			$sql .= " FROM `{$table}`";
			if ($where) {
				$sql .= " WHERE";
				foreach ($where as $field => $value) {
					$sql .= ' `'.$field.'` = \''.$value.'\' AND';
				}
				$sql = substr($sql, 0, -4); // Remove the last AND
			}
			$sql .= ($order AND $way) ? " ORDER BY `{$order}`" : "";
			$sql .= ($order AND $way == "desc") ? " DESC" : ($order) ? " ASC" : "";
			$sql .= ($limit) ? " LIMIT {$limit}" : "";
			
			// var_dump($sql); die();
			// Query the database
			if (!$result = mysql_query($sql)) $nitto_error->report('mysql', mysql_errno(), mysql_error(), true);
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $rows []= $row;
			// Collect and return the rows
			mysql_free_result($result);
			return $rows;
		}
		
		public function fetch_row($table, $fields = NULL, $where = NULL, $order = NULL, $way = NULL) {
			// Send off to fetch rows
			$row = $this->fetch_rows($table, $fields, $where, $order, $way, 1);
			// var_dump($row);
			if ($row) return $row[0];
			else return $row;
		}
		
		private function escape(&$statement) {
			// Escape the statement
			$statement = mysql_real_escape_string(trim($statement));
			return $statement;
		}
		
		private function prepare_fields(&$fields) {
			$statement = '';
			// Glue the fields together
			foreach ($fields as $field)	$statment .= '`'.$field.'`, ';
			// Remove the last comma
			$statement[strlen($statement)-1] = "\0";
			
			return $statement;
		}
	}
?>
