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
* A class to wrap the ShippingRate database object.
*
* incrementalMeasureType can be 'grams' or 'cents' 
*
* The example values given would create a ShippingRate called 'Australia Post Parcel'
* that has an expected delivery time of 3 days
* has a $10 flag fall
* with an extra $1 charge for each 500 grams of the order
* up to a maximum of 20kg. If the order is more than 20kg 
* there is another flagfall of $9 and each extra 500 grams is $2,
* So a package that weighs 2kg will cost: $10 + 4 * $1 = $14
* a package that weighs 0.4 kg will cost $10
* a package that weighs 20 kg will cost $10 + 40 * $1 = $50
* a package that weighs 22kg will cost ($10 + 40 * $1) + ($9 + 4 * $2) = $67
* a package that weighs 42kg will cost ($10 + 40 * $1) + ($9 + 40 * $2) + ($9 + 4 * $2) = $156
*
*/
class ShippingRate extends DAO {

	var $name; //NOT NULL,						eg Australia Post Parcel
	var $expectedDaysTaken; //NOT NULL			eg 3
	var $flagfall; //NOT NULL 					eg 1000
	var $incrementalMeasureType; //NOT NULL		eg grams
	var $incrementalMeasure; // NOT NULL		eg 500
	var $incrementalValue; // NOT NULL			eg 100
	var $maxMeasure; 		//					eg 20000
	
	
	function ShippingRate(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = "ShippingRate";
		$this->fields = Array('name', 'expectedDaysTaken', 'flagfall', 'incrementalMeasureType', 'incrementalMeasure',
								'incrementalValue', 'maxMeasure');
	}
	
	function inGrams() {
		$result = false;
		if (0 == strcmp($this->incrementalMeasureType, 'grams')) {
			$result = true;	
		}	
		return $result;
	}
	
	function inCents() {
		$result = false;
		if (0 == strcmp($this->incrementalMeasureType, 'cents')) {
			$result = true;	
		}	
		return $result;
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->name || (""== trim($this->name)) ) {
			$result = "name";
		}
		elseif ( !$this->expectedDaysTaken || (""== trim($this->expectedDaysTaken)) ) {
			$result = "expectedDaysTaken";
		}
		elseif ( !$this->flagfall || (""== trim($this->flagfall)) ) {
			$result = "flagfall";
		}
		elseif ( !$this->incrementalMeasureType || (""== trim($this->incrementalMeasureType)) ) {
			$result = "incrementalMeasureType";
		}
		elseif ( !$this->incrementalMeasure || (""== trim($this->incrementalMeasure)) ) {
			$result = "incrementalMeasure";
		}
		elseif ( !$this->incrementalValue || (""== trim($this->incrementalValue)) ) {
			$result = "incrementalValue";
		}
		elseif ( !$this->subsequentFlagfall || (""== trim($this->subsequentFlagfall)) ) {
			$result = "subsequentFlagfall";
		}
		elseif ( !$this->subsequentIncrementalValue || (""== trim($this->subsequentIncrementalValue)) ) {
			$result = "subsequentIncrementalValue";
		}
		
		return $result;
	}
	
			
}


?>