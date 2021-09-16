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
* A class to wrap the Coupon database object
*
*
*/
class Coupon extends DAO {

	var $code;     /* Not NULL */
	var $discount; /* Not NULL */
	var $start;    /* Not NULL */
	var $end;      /* Not NULL */
	
	function Coupon(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = "Coupon";
		$this->fields = Array("code", "discount", "start", "end");
	}
	
	function readFromCode() {
	    $table = $this->table;
	    $code = $this->code;
	    $sql = "SELECT * FROM $table where code='$code'";
	    return parent::readFromSQL($sql);  
	}
	
	function discountProduct($product) {
        $price = $product->cost;
        $result = $price - (($this->discount / 100) * $price);   
        //	   echo "discount calc: price = $price, discount = $this->discount, result = $result ";
        //	   print_r(this);
        return $result;
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->code || (""== trim($this->code)) ) {
			$result = "code";
		}
		elseif ( !$this->discount || (""== trim($this->discount)) ) {
			$result = "discount";
		}
		elseif ( !$this->start || (""== trim($this->start)) ) {
			$result = "start";
		}
		elseif ( !$this->end || (""== trim($this-> end)) ) {
			$result = "end";
		}
		
		return $result;
	}
	
			
}


?>