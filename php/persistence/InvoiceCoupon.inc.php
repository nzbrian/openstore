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
* A class to wrap the InvoiceCoupon database object
*
*
*/
class InvoiceCoupon extends DAO {

	var $orderId;	/* Not NULL */
	var $code;
	var $discount;	/* Not NULL */
	
	function InvoiceCoupon(&$config) {
        parent::DAO($config);
		$this->table = "InvoiceCoupon";
		$this->fields = Array('orderId', 'code', 'discount');
	}
	
	function readFromOrderId() {
	    $table = $this->table;
	    $orderId = $this->orderId;
	    $sql = "SELECT * FROM $table where orderId='$orderId'";
//	    echo "InvoiceCoupon::sql = $sql";
	    return parent::readFromSQL($sql);  
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->orderId || (""== trim($this->orderId)) ) {
			$result = "orderId";
		}
		elseif ( !$this->discount || (""== trim($this->discount)) ) {
			$result = "discount";
		}
		elseif ( !$this->code || (""== trim($this->code)) ) {
			$result = "code";
		}
		
		return $result;
	}
	
			
}


?>