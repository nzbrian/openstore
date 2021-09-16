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

require_once 'CodeRoot.inc.php';
require_once 'business/Config.inc.php';
require_once 'business/ProxyMother.inc.php';

require_once 'model/Cart.inc.php';
require_once 'model/CountryList.inc.php';
require_once 'persistence/Address.inc.php';
require_once 'persistence/Country.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'util/DisplayUtil.inc.php';
require_once 'util/HTTPUtil.inc.php';

$httpUtil = &new HTTPUtil();
$config = &new Config();
$cart = &Cart::getCart($config);
$shippingProxy = &ProxyMother::getShippingProxy($config);

$address = &$cart->address;
$countryId = $address->countryId;
if (!$countryId) {
	$countryId = 1;	
}
$countries = $shippingProxy->getCountries();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - shipping';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<form method="POST" action="<?php echo $config->getRootUrl(); ?>/presentation/viewCart.php">

<table border="0" cellpadding="0" cellspacing="0" width="600"> 
	<tr>
		<td valign="top">
		<p class="paragraphHeader">
			Shipping rates
		</p>
	</tr>
	<tr>
		<td align="left">
		Please select the country that this order will be delivered to from the list: 
			<?php echo $httpUtil->getObjectChoice('countryId', $address, $countries, 'country');  ?>
		</td>
	</tr>
	<tr>
		<td align="center"><input type="Submit" value="Continue" /></td>
	</tr>
	<tr>
		<td><img src="../images/transparent.gif" alt="" width="600" height="6" /></td>
	</tr>
</table>
</form>
<?php include "storeFooter.php"; ?>
</body>
</html>