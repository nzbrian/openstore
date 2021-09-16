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

require_once 'persistence/Address.inc.php';
require_once 'persistence/Country.inc.php';
require_once 'persistence/Customer.inc.php';
require_once 'persistence/SaleType.inc.php';

require_once 'util/DisplayUtil.inc.php';
require_once 'util/HTTPUtil.inc.php';

$httpUtil = &new HTTPUtil();
$displayUtil = &new DisplayUtil();
$config = &new Config();
$cart = &Cart::getCart($config);
$stockProxy = &ProxyMother::getStockProxy($config);
$shippingProxy = &ProxyMother::getShippingProxy($config);

include "AddToCart.inc.php";

// read in customer and address from POST variables
$customer = &new Customer($config);
$httpUtil->readPost($customer);
$saleType = $stockProxy->getSaleTypeGeneral();
$customer->saleTypeId = $saleType->id;

$address = &new Address($config);
$httpUtil->readPost($address);


// if they are not valid then redirect back to the checkout page
$customerInvalid = $customer->validate();
$addressInvalid = $address->validate();
$showPage = true;
if ($customerInvalid || $addressInvalid) {
	$customer = $cart->customer;
	$address = $cart->address;
	if ($customerInvalid || $addressInvalid) {
		$showPage = false;
		header('Location: ' . $config->getRootUrl() . '/presentation/checkout.php');
		echo "<p>CustomerValid: ", $customerInvalid, "</p>";
		echo "<p>AddressValid: ", $addressInvalid, "</p>";
		exit;	
	}
}
if($showPage) {

	$cart->customer = &$customer;
	$cart->address = &$address;
	$cart->store();
	
	$country = &$shippingProxy->getCountry($address->countryId);
	
	$shipping = &$shippingProxy->getShippingForCountry($country);


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - confirm order';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<script src="../js/openstore.js" type="text/javascript" language="javascript1.2"></script>
<SCRIPT type="text/javascript" language="javascript1.2">
<!--
	function validate(form) {
		var error = getReference('errorMessage', window.document);
		hideDiv(error);
		var check  = checkName(getReference('credit_name'), getReference('star_credit_name'), true);
		var result = check;	
		check  = checkCreditCard(getReference('credit_number'), (getReference('credit_type')).value, getReference('star_credit_number'), true);	
		result = result && check;	
		check  = checkInt(getReference('credit_expiry_month'), getReference('star_credit_expiry'), true);	
		result = result && check;	
		var checkMonth = check;
		check  = checkInt(getReference('credit_expiry_year'), getReference('star_credit_expiry'), true);	
		result = result && check;	
		if (!checkMonth && check) {
			showDiv(getReference('star_credit_expiry', window.document));
		}
		if (!result) {
			showDiv(error);
			result = false;	
		}
		else {
			result = true;	
			disableSubmit();
		}
		return result;
	}
	
	function disableSubmit() {
		var button = getReference('submitButton', window.document);
		button.value = "Please wait";
		button.disabled = "true";
	}
-->
</SCRIPT>
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<table border="0" cellpadding="0" cellspacing="0" width="600"> 

<tr>
	<td width="600" align="left"><span class="orderStage" align="left"> 1. Confirm your order: </span></td>
</tr>
<tr>
	<td><img src="../images/transparent.gif" width="600" height="10" alt="" /></td>
</tr>
<tr>
	<td valign="top" align="center">
			<table cellpadding="5" cellspacing="0" border='0' width="400">
		     
			<tr>
				<th colspan="2" align="left">Product</th>
				<th align="left">Quantity</th>
				<th align="left">Price</th>
			</tr>
		
			<?php
			$totalQuantity = 0;
			$totalCost = 0;
			$totalWeight = 0;
			$firstRow = true;
			$numProducts = count($cart->contents);
			$coupon = $cart->coupon;
			foreach ($cart->contents as $productId=>$number) {
				$product = new Product($config);
				$product->id = $productId;
				$product->read();
				$name = $product->name;
				$image = '..' . $product->productImage;
				$price = 0;
				if (null == $coupon) {
				    $price = $number * $product->cost;
				}
				else {
				    $price = $number * $coupon->discountProduct($product);   
				}
				$totalQuantity += $number;
				$totalCost += $price;
				$totalWeight += $number * $product->weight;
			?>
			<tr>
				<td>
					<img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" height="35" border="0"/>
				</td>
				<td align="left">
					<?php echo $name; ?>
				</td>
				<td align="left">
					<?php echo $number; ?>
				</td>
				<td align="left">
					<?php echo $config->getCurrency(), $displayUtil->displayDollars($price); ?>
				</td>
				
			</tr>	
			<?php	
			}
			
			$shippingCost = $shippingProxy->calculateShipping($shipping, $totalWeight, $totalCost);
			?>
			
			<tr>
				<td colspan="2" align="left">shipping - <?php echo $shipping->name; ?><br />(around <?php echo $shipping->expectedDaysTaken; ?> business days transit)</td>
				<td align="left"></td>
				<td align="left"><?php echo $config->getCurrency(), $displayUtil->displayDollars($shippingCost); ?></td>
			</tr>
			<tr>
			 <td align="center" colspan="4"><img src="../images/black.gif" width="100%" height="1" alt="" /></td>
			</tr>
			<tr>
				<th align="left" colspan="3">total cost</th>
				<th align="left">$<?php echo $config->getCurrency(), $displayUtil->displayDollars($shippingCost + $totalCost); ?></th>
			</tr>
			<tr>
			 <td align="center" colspan="4"><img src="../images/black.gif" width="100%" height="1" alt="" /></td>
			</tr>
			
			<tr>
				<td align="left" colspan="4">All prices include GST at 10%</td>
			</tr>
			<tr>
                <td align="left" colspan="2">
        			<?PHP
        			if (null != $coupon) {
        			?>
        				Coupon <i><?php echo $coupon->code ?></i>
        			<?PHP
        			}
        			?>
			    </td>
				<td colspan="2" align="right">
					<a class="highlight" href="<?php echo $config->getRootUrl(); ?>/presentation/editCart.php">change this order</a>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td><img src="../images/transparent.gif" width="600" height="20" alt="" /></td>
</tr>
<tr>
	<td width="600" align="left"><span class="orderStage" align="left">2. Confirm your delivery details: </span></td>
</tr>
<tr>
	<td><img src="../images/transparent.gif" width="600" height="10" alt="" /></td>
</tr>
<tr>
	<td align="center">
		<table cellpadding="5" cellspacing="0" border='0' width="400">	
			<tr>			
				<th align="left">Delivery details</th>
				<th align="left">Contact details</th>
			</tr>
			<tr>
				<td valign="top" align="left"
					<?php echo "$customer->salutation $customer->first $customer->middle $customer->last"; ?><br />
					<?php echo $address->street1; ?><br />
					<?php if ($address->street2) { echo $address->street2, '<br />';} ?>
					<?php echo $address->city; ?><br />
					<?php 
						if ($address->state) { 
							echo $address->state;
						} 
					?><br />
					
					<?php if ($address->postcode) { echo $address->postcode, '<br />';} ?>
					<?php 
						//print_r($country);
						echo $country->country; 
					?>
				</td>
				<td valign="top" rowspan="<?php echo $numProducts + 1; ?>" align="left">
					<?php echo $customer->email; ?><br />
					<?php echo $customer->phone1; ?><br />
					<?php if ($customer->phone2) { echo $customer->phone2;} ?>
					
				</td>
				
			</tr>
			<tr>
				<td colspan="2" align="right">
					<a class="highlight" href="<?php echo $config->getRootUrl(); ?>/presentation/checkout.php">change your details</a>
				</td>
			</tr>
			
		</table>
	</td>
</tr>
<tr>
	<td><img src="../images/transparent.gif" width="600" height="20" alt="" /></td>
</tr>
<tr>
	<td width="600" align="left"><span class="orderStage" align="left">3. Make your payment: </span></td>
</tr>
<tr>
	<td><img src="../images/transparent.gif" width="600" height="10" alt="" /></td>
</tr>
<tr>
	<td align="center">
		<form method="POST" action="order.php" onsubmit="return validate(this)">
		<input type="hidden" name="shipping" value="<?php echo $shipping->id; ?>" />
		<table cellpadding="5" cellspacing="0" border='0' width="400">	
			<tr>
				<td colspan="3" align="left"><b>If your order and delivery details are correct plases enter your payment details below: </b></td>
			</tr>
			<tr><td align="left">Name on card:</td><td align="left"><input type="text" name="credit_name" /></td>
				<td align="left">
					<div id='star_credit_name' style="visibility:hidden" align="left">&larr;</div>
				</td>
			</tr>
			<tr><td align="left">Card number: </td><td align="left"><input type="text" name="credit_number" /></td>
				<td align="left">
					<div id='star_credit_number' style="visibility:hidden" align="left">&larr;</div>
				</td>
			</tr>
			<tr><td align="left">Expiry date (month / year): </td>
				<td align="left">
					<select name="credit_expiry_month">
						<option value='-'>-</option>
					<?php 	
						for ($i = 1; $i < 13; $i++) {
							$value = $i;
							if ($i < 10) {
								$value = '0'.$i;	
							}
							echo "<option value='", $value , "'>", $i, "</option>";	
						}
					?>
					</select> / 
					<select name="credit_expiry_year">
						<option value='-'>-</option>
					<?php 	
						for ($i = 2004; $i < 2010; $i++) {
							$value = '0'. ($i - 2000);
							echo "<option value='", $value , "'>", $i, "</option>";	
						}
					?>
					</select>
				</td>
				<td align="left">
					<div id='star_credit_expiry' style="visibility:hidden" align="left">&larr;</div>
				</td>
			</tr>
			<tr>
				<td align="left">Card Type: </td>
				<td align="left">
					<select name="credit_type">
						<option value="visa">Visa</option>
						<option value="mastercard">Mastercard</option>
					</select>		
				</td>
			</tr>
			<tr><td align="right" colspan="3"><input type="submit" id="submitButton" value="Order Now"></td></tr>
			
			<tr>
				<td colspan='2'> 
					<div id='errorMessage' style="visibility:hidden"><b>Please correct the errors highlighted with a &larr;</b></div>
				</td>
			</tr>
		</table>
		</form>
	</td>
</tr>

<?php include(Config::getCommercialPrefix() . '/confirm.html'); ?>

</table>

<?php
$hideFooterProducts = true;
include "storeFooter.php"; 
?>
</body>
</html>

<?php 
	// press confirm to accept and place order
}


?>