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
* A class to wrap the Order database object
*
*
*/
class Order extends DAO {

	var $cost;	/* Not NULL */ 
	var $customerId;	/* Not NULL */
	var $addressId;	/* Not NULL */
	var $status; /* Not NULL */
	var $dateOrdered; /* Not NULL */
	var $password; /* Not NULL */
	var $couponId;
	
	function Order(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = 'AnOrder';
		$this->fields = Array('cost', 'customerId', 'addressId', 'status', 'dateOrdered', 'password', 'couponId');
	}
	
	function create() {
		$password = '';
		for ($i = 0; $i < 16; $i++) {
			$password .= $this->getChar(rand(0, 61));
		} 
		$this->password = $password;
		parent::createWithNulls();
	}
	
	function update() {
	   return parent::updateWithNulls();   
	}
	
	/*
	 * private static:
	 * takes an integer between 0 and 61 (inclusive) and returns an
	 * alphanumeric chracter.
	 */
	function getChar($int) {
		$result = 0;
		if ($int < 10) {
			$result = chr($int + 48);	
		}	
		else if ($int < 36) {
			$result = chr($int + 55);	
		}
		else {
			$result = chr($int + 61);	
		}
		return $result;
	}
	
	function setNow() {
		$this->dateOrdered = time();
	}
	
	/*
	 * The valid strings for $status accepted by the database.
	 */
	function setOrdered() {
		$this->status = 'ordered';
	}
	
	function setProcessing() {
		$this->status = 'processing';
	}
	
	function setAccepted() {
		$this->status = 'accepted';
	}
	
	function setShipped() {
		$this->status = 'shipped';
	}
	
	function setRejected() {
		$this->status = 'rejected';
	}
	
	function isRejected() {
		$result = false;
		if (0 == strcmp($this->status, 'rejected')) {
			$result = true;	
		}	
		return $result;
	}
	
	function setLost() {
		$this->status = 'lost';
	}
	
	function setReturned() {
		$this->status = 'returned';
	}
	
	function setClosed() {
		$this->status ='closed';
	}
	
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->cost || (""== trim($this->cost)) ) {
			$result = "cost";
		}
		elseif ( !$this->customerId || (""== trim($this->customerId)) ) {
			$result = "customerId";
		}
		elseif ( !$this->addressId || (""== trim($this->addressId)) ) {
			$result = "addressId";
		}
		elseif ( !$this->status || (""== trim($this->status)) ) {
			$result = "status";
		}
		elseif ( !$this->dateOrdered || (""== trim($this->dateOrdered)) ) {
			$result = "dateOrdered";
		}
		elseif ( !$this->password || (""== trim($this->password)) ) {
			$result = "password";
		}
		
		return $result;
	}
	
			
}


?>