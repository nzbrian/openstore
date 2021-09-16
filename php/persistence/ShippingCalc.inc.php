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
* A class to wrap the ShippingCalc database object.
*/
class ShippingCalc extends DAO {

	var $rateId; //NOT NULL
	var $measureFrom; //NOT NULL
	var $flagfall; //NOT NULL 					eg 1000
	var $incrementalMeasure; // NOT NULL		eg 500
	var $incrementalValue; // NOT NULL			eg 100
	
	
	function ShippingCalc(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = "ShippingCalc";
		$this->fields = Array('rateId', 'measureFrom', 'flagfall', 'incrementalMeasure', 'incrementalValue');
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->rateId || (""== trim($this->rateId)) ) {
			$result = "rateId";
		}
		elseif ( !$this->measureFrom || (""== trim($this->measureFrom)) ) {
			$result = "measureFrom";
		}
		elseif ( !$this->flagfall || (""== trim($this->flagfall)) ) {
			$result = "flagfall";
		}
		elseif ( !$this->incrementalMeasure || (""== trim($this->incrementalMeasure)) ) {
			$result = "incrementalMeasure";
		}
		elseif ( !$this->incrementalValue || (""== trim($this->incrementalValue)) ) {
			$result = "incrementalValue";
		}
		
		return $result;
	}
	
			
}


?>