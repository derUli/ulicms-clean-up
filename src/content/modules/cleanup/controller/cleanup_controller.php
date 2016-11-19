<?php
class CleanUpController {
	public function getCleanableTables() {
		$result = array ();
		$sql = "SELECT 
  TABLE_NAME, table_rows, data_length, index_length,  
  round(((data_length + index_length) / 1024 / 1024),2) as size_in_mb
FROM information_schema.TABLES 
WHERE TABLE_NAME in ('{prefix}log', '{prefix}history', '{prefix}mails') and TABLE_TYPE='BASE TABLE' and data_length + index_length > 0
ORDER BY data_length DESC;";
		$query = Database::query ( $sql, true );
		while ( $row = Database::fetchObject ( $query ) ) {
			$result [] = $row;
		}
		return $result;
	}
	public function getAllowedTables() {
		return array (
				tbname ( "log" ),
				tbname ( "history" ),
				tbname ( "mails" ) 
		);
	}
	public function cleanTable($table) {
		$allowed = $this->getAllowedTables ();
		if (in_array ( $table, $allowed )) {
			Database::query ( $table );
		}
	}
}