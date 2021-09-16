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

require_once 'persistence/DAO.inc.php';


/*
* A class to wrap the SaleType database object
*
*
*/
class SaleType extends DAO {

	var $type;	/* Not NULL */
	
	function SaleType(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = 'SaleType';
		$this->fields = Array('type');
	}
	
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->type || (''== trim($this->type)) ) {
			$result = 'type';
		}
		
		return $result;
	}
	
	function readFromType() {
		$sql = "SELECT * from $this->table WHERE type='$this->type'";
		return parent::readFromSQL($sql);
	}
	
			
}


?>