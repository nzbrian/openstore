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
?><?PHP

require_once 'adminmodel/OrderView.inc.php';
require_once 'persistence/ListAO.inc.php';


/*
 * public:
 * Represents a list of OrderView.
 */
class OrderViewList extends ListAO {
	
	function OrderViewList(&$config) {
        parent::ListAO($config);   
    }
    
	/*
	 * protected: call-back from ListAO
	 */
	function &createEmptyObject() {
		return new OrderView($this->config);
	}
	
	function readOrderView($field, $values) {
		$columns = $this->table . '.id';
		
		foreach($this->fields as $key) {
			$columns = $columns.",$key";
		}
		
		$where = 'WHERE ';
		
		$where .= '(';
		$orRequired = false;
		
		$escapedField = mysql_escape_string($field);
		foreach($values as $value) {
			if ($orRequired) {
				$where .= " OR ";
				
			}
			$where .= $escapedField. "='". mysql_escape_string($value). "'";
			$orRequired = true;
		}
		$where .= ') AND ';
		
		$where .= $this->table . '.customerId=Customer.id AND ' . $this->table . '.addressId=Address.id AND Address.countryId=Country.id';
		
		$sql = "SELECT $columns FROM $this->table, Customer, Address, Country $where ORDER BY $escapedField";
		
//		echo 'SQL is: ' . $sql;
		
		$this->readFromSQL($sql);		
	}
}


?>