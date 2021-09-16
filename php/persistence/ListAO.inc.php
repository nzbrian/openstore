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
 * public abstract:
 * The base class for lists of persistent objects. Only used for reading.
 */
class ListAO extends AccessObject {

	/*
	 * public:
	 * An array of the full database objects that this object has found.
	 * For instance in ProductList this $list contains Product objects.
	 * The list is indexed by the id of the object, eg for Product this is a list of Product::id=>Product
	 */
	var $list;
	
	function ListAO(&$config) {
        parent::AccessObject($config);
		$instance = &$this->createEmptyObject();
		$this->table = $instance->table;
		$this->fields = &$instance->fields;
	}	
	
	/*
	 * public:
	 * Takes 0,1 or two fields and values and populates $list with all objects that
	 * have field='value'.
	 * For example read('type', 'apple') would populate $list with all objects (rows) from the 
	 * database (table specified in AccessObject) that have 'apple' in the 'type' column.
	 * read() will return all objects in the table.
	 */
	function read($field1=FALSE, $value1=FALSE, $field2=FALSE, $value2=FALSE, $orderBy=FALSE) {		
		return $this->extendedRead($field1, $value1, $field2, $value2, FALSE, FALSE, $orderBy);
	}
	
	/*
	 * public:
	 * Takes 0,1 or two fields and values and populates $list with all objects that
	 * have field='value'.
	 * For example read('type', 'apple') would populate $list with all objects (rows) from the 
	 * database (table specified in AccessObject) that have 'apple' in the 'type' column.
	 * read() will return all objects in the table.
	 */
	function extendedRead($field1=FALSE, $value1=FALSE, $field2=FALSE, $value2=FALSE, $field3=FALSE, $value3=FALSE, $orderBy=FALSE) {		
		$columns = "id";
		
		foreach($this->fields as $key) {
			$columns .= ",$key";
		}
		
		$sql = "SELECT $columns FROM $this->table";
		if ($field1) {
			$sql .= " WHERE ". mysql_escape_string($field1). "='". mysql_escape_string($value1). "'";
		}
		if ($field2) {
			$sql .= " AND ". mysql_escape_string($field2). "='". mysql_escape_string($value2). "'";
		}
		if ($field3) {
			$sql .= " AND ". mysql_escape_string($field3). "='". mysql_escape_string($value3). "'";
		}
		if ($orderBy) {
			$sql .= ' ORDER BY ' . mysql_escape_string($orderBy);	
		}
		return $this->readFromSQL($sql);
	}
	
	
	/*
	 * public:
	 * Takes a list of values that a field can be and populates $list with 
	 * all objects that have the field equal to one in the list. 
	 */
	function readList($field, $values) {		
		$columns = "id";
		
		foreach($this->fields as $key) {
			$columns .= ",$key";
		}
		
		$escapedField = mysql_escape_string($field);
		
		$where = "WHERE ";
		$orRequired = false;
		foreach($values as $value) {
			if ($orRequired) {
				$where .= " OR ";
				
			}
			$where .= $escapedField. "='". mysql_escape_string($value). "'";
			$orRequired = true;
		}
		
		$sql = "SELECT $columns FROM $this->table $where ORDER BY $escapedField";
		$this->readFromSQL($sql);
	}
	
	/*
	 * protected abstract: call-back to implementing classes.
	 * return a new instance of whatever type of object the list will contain
	 */
	function &createEmptyObject() {
//		return new Product;
	}
	
	/* protected: */
	function readFromSQL($sql) {
	   $returnValue = null;
//		echo "<br>ListAO::readFromSQL(  $sql  )<br>";
		
		$result = array();	
		$db = &$this->openDatabase();
		$query = mysql_query($sql, $db);
		if ($query) {
		    $returnValue = TRUE;
			while ($row = &mysql_fetch_array($query, MYSQL_ASSOC)) {
				$object = &$this->createEmptyObject();
				$object->id = $row['id'];
//				echo "<br>Object:";
//				print_r(get_object_vars($object));
//				echo "<br>";
				
				foreach ($this->fields as $key) {
					$object->$key = stripslashes($row[$key]);
//					echo "<br>$key found <br>";
				}
				$result[$object->id] = $object;
			}
			mysql_free_result($query);
		}
		$this->closeDatabase($db);
		
//		echo "<br>result is: ";
//		print_r($result);
//		echo "<br>";
		
		$this->list = &$result;
		return $returnValue;
	}
	
	
	
}


?>