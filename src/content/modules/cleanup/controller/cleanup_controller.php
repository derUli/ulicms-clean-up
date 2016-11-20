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
	private function getAllowedTables() {
		return array (
				tbname ( "log" ),
				tbname ( "history" ),
				tbname ( "mails" ) 
		);
	}
	public function cleanTable($table) {
		$allowed = $this->getAllowedTables ();
		$result = null;
		if (in_array ( $table, $allowed )) {
			$result = Database::truncateTable ( $table, false );
		}
		return $result;
	}
	/*
	 * returns the size of all files in log folder in MB
	 */
	public function canCleanLogDir() {
		return ($this->getLogDirSizeInByte () > 0);
	}
	public function cleanLogDir() {
		return SureRemoveDir ( ULICMS_ROOT . "/content/log", false );
	}
	public function getLogDirSize() {
		return round ( $this->getDirSize ( ULICMS_ROOT . "/content/log" ) / 1024 / 1024, 2 );
	}
	public function getCrapFilesCount() {
		return count ( $this->getAllCrapFiles () );
	}
	public function getAllCrapFiles() {
		$annoyingFilenames = array (
				'.DS_Store', // mac specific
				'.localized', // mac specific
				'Thumbs.db' 
		); // windows specific
		
		$files = find_all_files ( ULICMS_ROOT );
		$crapFiles = array ();
		foreach ( $files as $file ) {
			if (in_array ( basename ( $file ), $annoyingFilenames )) {
				$crapFiles [] = $file;
			}
		}
		return $crapFiles;
	}
	private function getLogDirSizeInByte() {
		return ($this->getDirSize ( ULICMS_ROOT . "/content/log" ));
	}
	public function canCleanTmpDir() {
		return ($this->getTmpDirSizeInByte () > 0);
	}
	public function cleanTmpDir() {
		return SureRemoveDir ( ULICMS_ROOT . "/content/tmp", false );
	}
	public function getTmpDirSize() {
		return round ( $this->getDirSize ( ULICMS_ROOT . "/content/tmp" ) / 1024 / 1024, 2 );
	}
	private function getTmpDirSizeInByte() {
		return ($this->getDirSize ( ULICMS_ROOT . "/content/tmp" ));
	}
	private function getDirSize($dir_name) {
		$dir_size = 0;
		if (is_dir ( $dir_name )) {
			if ($dh = opendir ( $dir_name )) {
				while ( ($file = readdir ( $dh )) !== false ) {
					if ($file != "." && $file != "..") {
						if (is_file ( $dir_name . "/" . $file )) {
							$dir_size += filesize ( $dir_name . "/" . $file );
						}
						/* check for any new directory inside this directory */
						if (is_dir ( $dir_name . "/" . $file )) {
							$dir_size += $this->getDirSize ( $dir_name . "/" . $file );
						}
					}
				}
			}
		}
		closedir ( $dh );
		return $dir_size;
	}
}