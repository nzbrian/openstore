<?php
/*
copyright Brian Bannister 2004

This file is part of Open Store. http://openstore.org/

Open Store is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Open Store is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Open Store; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
?><?php



require_once 'persistence/AccessObject.inc.php';

	
/*
* The base class for persistent objects
*/
class DAO extends AccessObject {


	/* The object id from the database */
	var $id;
	
    function DAO(&$config, $id = NULL) {
        parent::AccessObject($config);
        $this->id = $id;
    }
    
	/*
	 * Creates this object in the database and sets $id from the 
	 * database's auto increment. 
	 * TODO: Returns true iff the create succeeded.
	 * TODO: escape values
	 */
	function create() {
		$columns = "";
		$row = "";
		
		$commaRequired = false;
		foreach($this->fields as $key) {
			if ($commaRequired) {
				$columns .= ", ";
				$row .= ", ";
			}
			$columns .= "$key";
			$value = mysql_escape_string($this->$key);
			$row .= "'$value'";
			$commaRequired = true;
		}
		
		$sql = "INSERT INTO $this->table ($columns) VALUES ($row)";
	
//		echo "<br> SQL is $sql <br>";
	
		$conn = &$this->openDatabase();
		$result = mysql_query($sql, $conn);
//		$rowsAffected = mysql_affected_rows();
//		echo "<br> rows affected: $rowsAffected <br>";
		$this->id = mysql_insert_id($conn);
		$this->closeDatabase($conn);
		return $result;
	}
	
	function createWithNulls() {
		$columns = "";
		$row = "";
		
		$commaRequired = false;
		foreach($this->fields as $key) {
			if ($commaRequired) {
				$columns .= ", ";
				$row .= ", ";
			}
			$columns .= "$key";
			$value = mysql_escape_string($this->$key);
			if (!0 == strcmp('', $value) && !0 == $value) {
			    $row .= "'$value'";
			}
			else {
			    $row .= " null ";
			}
			$commaRequired = true;
		}
		
		$sql = "INSERT INTO $this->table ($columns) VALUES ($row)";
	
//		echo "<br> SQL is $sql <br>";
	
		$conn = &$this->openDatabase();
		$result = mysql_query($sql, $conn);
//		$rowsAffected = mysql_affected_rows();
//		echo "<br> rows affected: $rowsAffected <br>";
		$this->id = mysql_insert_id($conn);
		$this->closeDatabase($conn);
		return $result;
	}
	
	/*
	 * Reads in this object from the database. 
	 * TODO: Returns true iff the read succeeded.
	 */
	function read() {		
		$columns = "id";
		
		foreach($this->fields as $key) {
			$columns .= ",$key";			
		}
		
		$sql = "SELECT $columns FROM $this->table WHERE id='". mysql_escape_string($this->id). "'";
		return $this->readFromSQL($sql);
	}
	
	function readFromSQL($sql) {	
	
//		echo "<br> SQL is: $sql <br>";
	
		$returnFlag = false;	
		$db = &$this->openDatabase();
		$result = mysql_query($sql, $db);
		if ($result) {
			$row = &mysql_fetch_array($result, MYSQL_ASSOC);
			if ($row) {
				$this->id = $row['id'];			
				$returnFlag = true;
				foreach ($this->fields as $key) {
					$this->$key = stripslashes($row[$key]);
				}
			} 
		}
		mysql_free_result($result);
		$this->closeDatabase($db);
		return $returnFlag;
	}
	
	/*
	 * Updates this object's record in the database (by $id).
	 * TODO: return true iff the update was successful.
	 */
	function update() {
		$sql = "UPDATE $this->table SET ";		
		$commaRequired = false;
		foreach($this->fields as $key) {
			if ($commaRequired) {
				$sql .= ", ";
			}
			$value = mysql_escape_string($this->$key);
			$sql .= "$key='$value'";
			$commaRequired = true;
		}
		
		$sql .= " WHERE id='". mysql_escape_string($this->id). "'";
		
//		echo "<br> SQL is $sql <br>";
		
		$db = &$this->openDatabase();
		$result = mysql_query($sql, $db);
		$this->closeDatabase($db);
		return $result;
	}
	
	function updateWithNulls() {
		$sql = "UPDATE $this->table SET ";		
		$commaRequired = false;
		foreach($this->fields as $key) {
			if ($commaRequired) {
				$sql .= ", ";
			}
			$value = mysql_escape_string($this->$key);
			if (!0 == strcmp('', $value) && !0 == $value) {
			    $sql .= "$key='$value'";
			}
			else {
			     $sql .= "$key= null ";   
			}
			$commaRequired = true;
		}
		
		$sql .= " WHERE id='". mysql_escape_string($this->id). "'";
		
//		echo "<br> SQL is $sql <br>";
		
		$db = &$this->openDatabase();
		$result = mysql_query($sql, $db);
		$this->closeDatabase($db);
		return $result;
	}
	
	/*
	 * Removes this object from the database. 
	 * TODO: Returns true iff the removal was successful.
	 */
	function remove() {
		$sql = "DELETE from $this->table where id='". mysql_escape_string($this->id). "'";
//		echo "<br> SQL is $sql <br>";
		$db = &$this->openDatabase();
		$result = mysql_query($sql, $db);
		$this->closeDatabase($db);
		return $result;
	}
	
	function toString() {
		$result = "id = $this->id";
		foreach ($this->fields as $field) {
			$result = $result . ', ' . $field . ' = ' . $this->$field;
		}
		return $result;
	}
}


?>