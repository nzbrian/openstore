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
require_once 'persistence/Customer.inc.php';
require_once 'persistence/Address.inc.php';
require_once 'util/HTTPUtil.inc.php';

$httpUtil = &new HTTPUtil();
$config = &new Config();
$cart = &Cart::getCart($config);
$shippingProxy = &ProxyMother::getShippingProxy($config);

$customer = &$cart->customer;
if (!$customer) {
	$customer = &new Customer($config);
	$cart->customer = &$customer;
}

$address = &$cart->address;
if (!$address) {
	$address = &new Address($config);
	$cart->address = &$address;
}


$showPage = true;
if (count(&$cart->contents) == 0) {
		$showPage = false;
		header('Location: ' . $config->getRootUrl() . '/presentation/viewCart.php');
		echo "<p>Your shopping basket is empty!</p>";
		exit;	
}
if ($showPage) {
	$countries = $shippingProxy->getCountries();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - checkout';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<script src="../js/openstore.js" type="text/javascript" language="javascript1.2"></script>
<SCRIPT type="text/javascript" language="javascript1.2">
<!--
	function validate(form) {
		var error = getReference('errorMessage');
		hideDiv(error);
		var check  = checkName(getReference('first'), getReference('star_first'), true);
		var result = check;	
		check  = checkName(getReference('last'), getReference('star_last'), true);	
		result = result && check;	
		check  = checkEmail(getReference('email'), getReference('star_email'), true);	
		result = result && check;	
		check  = checkPhone(getReference('phone1'), getReference('star_phone'), true);
		result = result && check;	
		check  = checkString(getReference('street1'), getReference('star_street'), true);
		result = result && check;	
		check  = checkString(getReference('city'), getReference('star_city'), true);	
		result = result && check;	
		
		if (!result) {
			showDiv(error);
			result = false;	
		}
		else {
			result = true;	
		}
		return result;
	}
-->
</SCRIPT>
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<form method="POST" action="<?php echo $config->getSecureUrl(), '/presentation/' ?>confirm.php" onsubmit="return validate(this)">
<input type="hidden" name="emptyCart" value="true" />
<?php
foreach ($cart->contents as $productId=>$number) {
?>
	<input type="hidden" name="product_<?php echo "$productId"; ?>" value="<?php echo "$number"; ?>" />
<?PHP
}
?>
<table border='0' cellspacing="0" cellpadding="0" width="600">
<tr>
	<td colspan="5" align="left">Enter details for shopper:</td>
</tr>
<tr>
	<td colspan="5" align="left"><img src="../images/transparent.gif" alt="" width="600" height="10" /></td>
</tr>
<tr>
	<td align="left">Salutation:</td>
	<td align="left"><?php echo $httpUtil->getInputChoice('salutation', $customer, array('Ms'=>'Ms', 'Miss'=>'Miss', 'Mrs'=>'Mrs', 'Mr'=>'Mr', 'Princess'=>'Princess', 'Lady'=>'Lady', 'Sir'=>'Sir'), 1); ?></td>
	<td></td>
	<td align="left">Street Address:</td>
	<td align="left"><?php echo $httpUtil->getInput('street1', $address, 20, 8);  ?><span id='star_street' style="visibility:hidden">&larr;</span></td>
</tr>
<tr>
	<td align="left">First name:</td>
	<td align="left"><?php echo $httpUtil->getInput('first', $customer, 20, 2);  ?><span id='star_first' style="visibility:hidden">&larr;</span></td>
	<td></td>
	<td align="left">Street&nbsp;Address&nbsp;2:</td>
	<td align="left"><?php echo $httpUtil->getInput('street2', $address, 20, 9);  ?></td>
</tr>
<tr>
	<td align="left">Middle name:</td>
	<td align="left"><?php echo $httpUtil->getInput('middle', $customer, 20, 3);  ?></td>
	<td></td>
	<td align="left">City:</td>
	<td align="left"><?php echo $httpUtil->getInput('city', $address, 20, 10);  ?><span id='star_city' style="visibility:hidden">&larr;</span></td>
</tr>
<tr>
	<td align="left">Last name:</td>
	<td align="left"><?php echo $httpUtil->getInput('last', $customer, 20, 4); ?><span id='star_last' style="visibility:hidden">&larr;</span></td>
	<td></td>
	<td align="left">State:</td>
	<td align="left"><?php echo $httpUtil->getInput('state', $address, 20, 11);  ?></td>
</tr>
<tr>
	<td align="left">Email address:</td>
	<td align="left"><?php echo $httpUtil->getInput('email', $customer, 20, 5); ?><span id='star_email' style="visibility:hidden">&larr;</span></td>
	<td></td>
	<td align="left">Postcode:</td>
	<td align="left"><?php echo $httpUtil->getInput('postcode', $address, 20, 12);  ?></td>
</tr>
<tr>
	<td align="left">Daytime&nbsp;Phone:</td>
	<td align="left"><?php echo $httpUtil->getInput('phone1', $customer, 20, 6);  ?><span id='star_phone' style="visibility:hidden">&larr;</span></td>
	<td></td>
	<td align="left">Country:</td>
	<td align="left"><?php echo $httpUtil->getObjectChoice('countryId', $address, $countries, 'country', 13);  ?></td>
</tr>
<tr>
	<td align="left">Evening Phone:</td>
	<td align="left"><?php echo $httpUtil->getInput('phone2', $customer, 20, 7);  ?></td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<td colspan='5' align="center"> 
		<IMG src="../images/transparent.gif" width="1" height="10" border="0" alt=""/>
	</td>
</tr>

<tr>
	<td colspan='5' align="center"> 
		<input type="Submit" value="Continue" />
	</td>
</tr>

<tr>
	<td colspan='5' align="center"> 
		<IMG src="../images/transparent.gif" width="1" height="10" border="0" alt="" />
	</td>
</tr>

<tr>
	<td colspan='5' align="center"> 
		<div id='errorMessage' style="visibility:hidden"><b>Please correct the errors highlighted with an &larr;</b></div>
	</td>
</tr>
</table>
</form>
<?php include "storeFooter.php"; ?>
</body>


</html>
<?PHP
}
?>