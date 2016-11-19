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
	/*
	 * returns the size of all files in log folder in MB
	 */
	public function canCleanLogDir() {
		return ($this->getDirSize () > 0);
	}
	public function getLogDirSize() {
		return round ( $this->getDirSize ( ULICMS_ROOT . "/content/log" ) / 1024 / 1024, 2 );
	}
	private function getDirSize($dir_name) {
		$dir_size = 0;
		if (is_dir ( $dir_name )) {
			if ($dh = opendir ( $dir_name )) {
				while ( ($file = readdir ( $dh )) !== false ) {
					if ($file != "." && $file != "..") {
						if (is_file ( $dir_name . " / " . $file )) {
							$dir_size += filesize ( $dir_name . " / " . $file );
						}
						/* check for any new directory inside this directory */
						if (is_dir ( $dir_name . " / " . $file )) {
							$dir_size += get_dir_size ( $dir_name . " / " . $file );
						}
					}
				}
			}
		}
		closedir ( $dh );
		return $dir_size;
	}
}