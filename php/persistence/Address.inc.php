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


require_once  'persistence/DAO.inc.php';


/*
* A class to wrap the Address database object
*
*
*/
class Address extends DAO {

	var $street1;	/* Not NULL */
	var $street2;
	var $city; 	/* Not NULL */
	var $state;
	var $postcode;
	var $countryId;	/* Not NULL */
	
	function Address(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = "Address";
		$this->fields = Array("street1", "street2", "city", "state", "postcode", "countryId");
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->street1 || (""== trim($this->street1)) ) {
			$result = "street1";
		}
		elseif ( !$this->city || (""== trim($this->city)) ) {
			$result = "city";
		}
		elseif ( !$this->countryId || (""== trim($this->countryId)) ) {
			$result = "countryId";
		}
		
		return $result;
	}
	
			
}


?>