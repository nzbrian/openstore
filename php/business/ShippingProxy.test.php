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


require_once '../../webroot/presentation/CodeRoot.inc.php';
require_once 'business/ProxyMother.inc.php';

require_once 'persistence/Country.inc.php';
require_once 'persistence/CountryShipping.inc.php';
require_once 'persistence/ShippingRate.inc.php';

require_once 'util/DisplayUtil.inc.php';


function showCost($rate, $weight, &$shippingProxy) {
	$shippingCost = $shippingProxy->calculateShipping($rate, $weight, 0);
	
	echo 'weight = ' . DisplayUtil::displayKg($weight) . "kg \n";
	echo 'shippingCost = $' . DisplayUtil::displayDollars($shippingCost) . "\n\n";
}

$config = new Config();
$aCountry = new Country($config, 2);
$aCountry->read();
$shippingProxy = ProxyMother::getShippingProxy($config);
$rate = $shippingProxy->getShippingForCountry($aCountry);

echo "country is $aCountry->country \n";
echo "rate is $rate->name, with flagfall=$rate->flagfall \n";
echo "incrementalMeasure=$rate->incrementalMeasure, incrementalValue=$rate->incrementalValue\n";
echo "maxMeasure=$rate->maxMeasure\n\n";

showCost($rate, 10, $shippingProxy);
showCost($rate, 999, $shippingProxy);
showCost($rate, 1000, $shippingProxy);
showCost($rate, 1001, $shippingProxy);
showCost($rate, 1001, $shippingProxy);
showCost($rate, 1500, $shippingProxy);
showCost($rate, 1999, $shippingProxy);
showCost($rate, 2000, $shippingProxy);
showCost($rate, 3000, $shippingProxy);
showCost($rate, 19000, $shippingProxy);
showCost($rate, 20000, $shippingProxy);
showCost($rate, 20001, $shippingProxy);
showCost($rate, 20999, $shippingProxy);
showCost($rate, 21000, $shippingProxy);
showCost($rate, 22000, $shippingProxy);
showCost($rate, 39000, $shippingProxy);
showCost($rate, 39999, $shippingProxy);
showCost($rate, 40000, $shippingProxy);
showCost($rate, 40001, $shippingProxy);
showCost($rate, 41000, $shippingProxy);
showCost($rate, 700 * 6, $shippingProxy);

$check = $shippingProxy->checkShippingForCountry($rate, $australia->id);
echo 'checking rate for country: ', $check;

?>