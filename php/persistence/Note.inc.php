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
* A class to wrap the Note database object
*
*
*/
class Note extends DAO {

	var $note;	/* Not NULL */
	var $date;	/* Not NULL */
	var $orderId;	/* Not NULL */ 
	
	function Note(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = "Note";
		$this->fields = Array("note", "date", "orderId");
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->note || (""== trim($this->note)) ) {
			$result = "note";
		}
		elseif ( !$this->date || (""== trim($this->date)) ) {
			$result = "date";
		}
		elseif ( !$this->orderId || (""== trim($this->orderId)) ) {
			$result = "orderId";
		}
		
		return $result;
	}
	
			
}


?>