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
require_once 'persistence/Coupon.inc.php';
require_once 'persistence/Country.inc.php';
require_once 'persistence/Product.inc.php';

require_once 'util/DisplayUtil.inc.php';

$config = &new Config();

include "AddToCart.inc.php";

$shippingProxy = &ProxyMother::getShippingProxy($config);
$stockProxy = &ProxyMother::getStockProxy($config);
$displayUtil = &new DisplayUtil();

$cart = &Cart::getCart($config);
$address = &$cart->address;

$countryId = $_POST['countryId'];
if ($countryId) {
	if (! $address) {
		$address = &new Address($config);	
	}	
	$address->countryId = $countryId;
	$cart->address = &$address;
	$cart->store();
	$cart = &Cart::getCart($config);
}

$countryId = $address->countryId;
if (!$countryId) {
	$countryId = 1;	
}
$country = $shippingProxy->getCountry($countryId);

$shippingRate = $shippingProxy->getShippingForCountry($country);

$coupon = $cart->coupon;
//echo "coupon is: ";
//print_r($coupon);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - shopping basket';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<script src="../js/openstore.js" type="text/javascript" language="javascript1.2"></script>
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<?PHP
if ($cart->contents) {
    $colspan = 0;
    if (null != $coupon) {
        $colspan = 5;   
    }
    else {
        $colspan = 4;   
    }
?>

<form id="couponForm" action="" method="POST">
	<table border="0" cellpadding="5" width="500">
		<tr>
			<th></th>
			<th>Product name</th>
			<th align="right">Quantity</th>
		<?PHP
		      if (null != $coupon) {
		?>
            <th align="right">
                Full price  
            </th>
            <th align="right">
                Discount price 
            </th>
		<?PHP   
		      }
		      else {
		?>
			<th align="right">Price</th>
	    <?PHP
		      }
	    ?>
		</tr>
	
		<?php
		$totalQuantity = 0;
		$totalCost = 0;
		$totalWeight = 0;
		
		$saleType = $stockProxy->getSaleTypeGeneral();
		foreach ($cart->contents as $productId=>$number) {
			$product = $stockProxy->getAProduct($productId, $saleType);
			$name = $product->name;
			$image = '..' . $product->productImage;
			$price = $number * $product->cost;
			$fullPrice = $price;
			if (null != $coupon) {
			     $price = $number * $coupon->discountProduct($product);   
			}
			$totalQuantity += $number;
			$totalCost += $price;
			$totalWeight += $number * $product->weight;
			$url = $config->getRootUrl() . '/presentation/viewProduct.php?product=' . $productId;
		?>
		<tr>
			<td>
				<a href="<?php echo $url; ?>"><img src="<?php echo $image; ?>" alt="$name" height="35" border="0"/></a>
			</td><td align="center">
				<a href="<?php echo $url; ?>"><?php echo $name; ?></a>
			</td><td align="right">
				<?php echo $number; ?>
			</td>
			
		<?PHP
		      if (null != $coupon) {
		?>
            <td align="right">
				<?php echo $config->getCurrency(), $displayUtil->displayDollars($fullPrice); ?>
            </td>
		<?PHP   
		      }
		?>
			<td align="right">
				<?php echo $config->getCurrency(), $displayUtil->displayDollars($price); ?>
			</td>
		</tr>	
		<?php	
		}
		
		$shippingCost = $shippingProxy->calculateShipping($shippingRate, $totalWeight, $totalCost);
		?>
		
		<tr>
			<td colspan="<?php echo $colspan ?>" align="center"><img src="../images/black.gif" alt="" width="500" height="1" /></td>
		</tr>
		<tr>
			<td colspan="<?php $width = $colspan - 2; echo $width; ?>" rowspan="3"></td>
			<td align="right">Total price</td>
			<td align="right"><?php echo $config->getCurrency(), $displayUtil->displayDollars($totalCost); ?></td>
		</tr>
	
		<tr>
			<td align="right">Estimated shipping<br />to <?php echo $country->country ?></td>
			<td align="right"><?php echo $config->getCurrency(), $displayUtil->displayDollars($shippingCost); ?></td>
		</tr>
	
		<tr>
			<th align="right">Checkout price</th>
			<th align="right"><?php echo $config->getCurrency(), $displayUtil->displayDollars($totalCost + $shippingCost); ?></th>
		</tr>
		<tr>
			<td colspan="<?php echo $colspan ?>"><img src="../images/transparent.gif" alt="" width="1" height="6" /></td>
		</tr>
		<tr>
			<td colspan="<?php echo $colspan ?>" align="left">
<?php include(Config::getCommercialPrefix() . '/viewCart.inc.php'); ?>	
			If your delivery address is not in <?php echo $country->country ?> please <a class="highlight" href="<?php echo $config->getRootUrl() ?>/presentation/shipping.php">click here</a> to change it.</td>
		</tr>
		<tr>
		  <td align="left" colspan="<?php echo $colspan ?>">
		      If you have a coupon code enter it here 
		      <input type="hidden" name="updateCoupon" value="true" />
              <input type="text" id="coupon" name="coupon" maxlength="10" value="<?php echo $coupon->code ?>" style="width:80px"/>
		      and click <a href="" class="highlight" onclick="submitForm('couponForm');return false;">update coupon</a>, 
		      otherwise <a href="<?php echo Config::getRootUrl() ?>/presentation/index.php" class="highlight"><b>continue shopping</b></a>,
		      or <a class="highlight" href="<?php echo $config->getRootUrl() ?>/presentation/editCart.php">update your order</a>.
		  </td>
		</tr>
		<tr>
			<td colspan="<?php echo $colspan ?>"><img src="../images/transparent.gif" alt="" width="1" height="3" /></td>
		</tr>
		<tr>
			<td colspan="<?php echo $colspan ?>" align="center">
				<a class="highlight" href="<?php echo $config->getRootUrl() ?>/presentation/index.php">continue shopping</a>
				<img src="../images/black.gif" width="1" height="6" alt="" />
				<a class="highlight" href="<?php echo $config->getRootUrl() ?>/presentation/editCart.php">update order</a>
				<img src="../images/black.gif" width="1" height="6" alt="" />
				<a class="highlight" href="<?php echo $config->getRootUrl() ?>/presentation/shipping.php">change shipping</a>
				<img src="../images/black.gif" width="1" height="6" alt="" />
				<a class="highlight" href="<?php echo $config->getRootUrl() ?>/presentation/checkout.php">check out</a>
			</td>
		</tr>
	</table>

</form>
<?php
}
else {
?>
You don't have anything in your basket yet!
<?php
}
?>
<?php include "storeFooter.php"; ?>
</body>
</html>