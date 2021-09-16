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

require_once 'model/ShippingCalcList.inc.php';

require_once 'persistence/Country.inc.php';
require_once 'persistence/CountryShipping.inc.php';
require_once 'persistence/ShippingCalc.inc.php';
require_once 'persistence/ShippingRate.inc.php';

/*
 * This class priveds a facade to all calculations relating to shipping
 */
class ShippingProxy {
    
    var $config;
    
    function ShippingProxy(&$config) {
        $this->config = &$config;   
    }
	
	/*
	 * public static:
	 * Currently each country only has one shipping provider. This method will return the correct ShippingRate for that country.
	 * $country is an instance of Country
	 * returns an instance of shippingRate
	 */
	function &getShippingForCountry(&$country) {
		return $this->getShippingForCountryId($country->id);
	}	
	
	/*
	 * public static:
	 * Currently each country only has one shipping provider. This method will return the correct ShippingRate for that country.
	 * $countryId is a number that is the id of a country
	 * returns an instance of shippingRate
	 */
	function &getShippingForCountryId($countryId) {  
		$countryShipping = &new CountryShipping($this->config);
		$db_id = mysql_escape_string($countryId);
		$sql = "SELECT * FROM CountryShipping WHERE countryId='$db_id'";
		$countryShipping->readFromSQL($sql);
		
		$shippingRate = &new ShippingRate($this->config, $countryShipping->rateId);
		$shippingRate->read();
		return $shippingRate;   
	}
	
	/* 
	 * public static:
	 * checks that the provided shippingRate is valid for a country.
	 * This allows us to let the user choose a shippingRate without us worrying that it will not be valid for their country.
	 */
	function checkShippingForCountry(&$shippingRate, $countryId) {
	   $result = false;
	   
	   $correctShippingRate = &$this->getShippingForCountryId($countryId);
	   if ($shippingRate->id == $correctShippingRate->id) {
	       $result = true;   
	   } 
	   
	   return $result;   
	}
	
	/*
	 * public static:
	 * Finds out if you are using weight based or cost based shipping and calls the correct calculate method.
	 *
	 */
	function calculateShipping(&$shippingRate, $weight, $cost) {		
		$quantity = 0;
		if ($shippingRate->inGrams()) {
			$quantity = $weight;	
		}
		else {
			$quantity = $cost;	
		}
		return $this->calculateShippingFromQuantity($shippingRate, $quantity);		
	}
	
	function calculateShippingFromQuantity(&$shippingRate, $quantity) {
		$result = 0;
		
		$maxMeasure = $shippingRate->maxMeasure;
		$shippingCalcs = &new ShippingCalcList($this->config);
		$shippingCalcs->read('rateId', $shippingRate->id);
		
		if ($quantity <= $maxMeasure) {
			$result = $this->calculatePartialRate($shippingRate, $shippingCalcs->list, $quantity);	
		}
		else {
			$maxMeasureQuotient = floor($quantity / $maxMeasure);
			$maxMeasureCost = $this->calculatePartialRate($shippingRate, $shippingCalcs->list, $maxMeasure);	
			$result = $maxMeasureQuotient * $maxMeasureCost ;
			
			$quantityRemaining = $quantity - ($maxMeasureQuotient * $maxMeasure);
			$result += $this->calculatePartialRate($shippingRate, $shippingCalcs->list, $quantityRemaining);
		}
		
		return $result;
	}
	
	/*
	 * shippingRate is the base shipping rate
	 * shippingCalcs is an array of the shippingCalcs for this rate
	 * quantity is the measure to calculate and must be <= shippingRate->maxMeasure
	 */
	function calculatePartialRate($shippingRate, &$shippingCalcs, $quantity) {
		// a hack as shippingRate doesn't have a measureFrom field
		$correctCalc = &$shippingRate;
		$correctCalc->measureFrom = 0;
		
		foreach($shippingCalcs as $shippingCalc) {
			if (($shippingCalc->measureFrom > $correctCalc->measureFrom) && ($shippingCalc->measureFrom <= $quantity)) {
				$correctCalc = $shippingCalc;	
			}
		}
		
		$result = $correctCalc->flagfall;
		
		$quantityAfterFlagfall = $quantity - $correctCalc->measureFrom;
		if (0 < $quantityAfterFlagfall && 0 < $correctCalc->incrementalMeasure) {
			$incrementsRemaining = floor ($quantityAfterFlagfall / $correctCalc->incrementalMeasure);
			$result += $incrementsRemaining * $correctCalc->incrementalValue;
		}
		
		return $result;
	}
	
	function &findShippingCalc(&$shippingRate, $quantity) {
		$result = null;
		
		$calc = &new ShippingCalc($this->config);		
		$rateId = mysql_escape_string($shippingRate->id);
		$escapedMeasure = mysql_escape_string($measure);
		$sql = "SELECT * FROM ShippingCalc WHERE rateId='" . $rateId . "' AND measureFrom<='" . $escapedMeasure . "' 
					ORDER BY measureFrom DESC LIMIT 1";
		
		$calc->readFromSQL($sql);
		if ($calc->id) {
			$result = $calc;	
		}
		return $calc;
	}
	
	function &getCountries() {
        $countries = &new CountryList($this->config);
        $countries->read();     
        return $countries->list;
	}
	
	function getCountry($countryId) {
	    $result = null;
        $country = &new Country($this->config, $countryId);
        $country->read();   
        if (null == $country->validate()) {
            $result = $country;  
        }
        return $result;
	}
}

?>