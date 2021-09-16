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
require_once 'persistence/Coupon.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'util/DisplayUtil.inc.php';

$displayUtil = &new DisplayUtil();
$config = &new Config();
$cart = &Cart::getCart($config);
$stockProxy = &ProxyMother::getStockProxy($config);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - update shopping basket';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<script src="../js/openstore.js" type="text/javascript" language="javascript1.2"></script>
<SCRIPT type="text/javascript" language="javascript">
<!--
	
	function validate(form) {
		var error = getReference('error_message', window.document);
		hideDiv(error);
		var result = true;
		var check = true;
		<?php 
				foreach ($cart->contents as $productId=>$number) {
					echo "\t\tcheck  = checkIntLessThan(getReference('product_", $productId, "'), getReference('star_", $productId, "'), false, " , Config::getMaxProductQuantityPerOrder() + 1 , "); \n";	
					echo "\t\tresult = result && check; \n";	
				}
				?>;
		if (!result) {
			showDiv(error);	
		}
		return result;
	}
-->
</SCRIPT>
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<form method="POST" name='editCart' action="viewCart.php" onsubmit="return validate(this)">
<input type="hidden" name="emptyCart" value="true" />

<?PHP
$coupon = $cart->coupon;
$colspan = 0;
if (null == $coupon) {
    $colspan = 5;   
}
else {
    $colspan = 6;   
}
?>

<table border="0" cellpadding="5" width="500">
	<tr>
	   <th></th>
	   <th align="center">Product Name</th>
	   <th align="right">Quantity</th>
	   <th></th>
	   <?PHP
	       if (null == $coupon) {
	   ?>
	   <th align="right">Price (each)</th>
	   <?PHP
	       }
	       else {
	   ?>
	   
	   <th align="right">Full price (each)</th>
	   <th align="right">Discount price (each)</th>
	   
	   <?PHP
	       }
	   ?>
    </tr>
<?php
$saleType = &$stockProxy->getSaleTypeGeneral();
foreach ($cart->contents as $productId=>$number) {
	$product = &$stockProxy->getAProduct($productId, $saleType);
	$name = $product->name;
	$image = '..' . $product->productImage;
	$price = $product->cost;
    $fullPrice = $price;
	if (null != $coupon) {
	   $price = $coupon->discountProduct($product);   
	}
	$url = $config->getRootUrl() . '/presentation/viewProduct.php?product=' . $productId;
?>
<tr>
	<td>
		<a href="<?php echo $url; ?>"><img src="<?php echo $image; ?>" alt="$name" height="35" border="0"/></a>
	</td><td align="center">
		<a href="<?php echo $url; ?>"><?php echo $name; ?></a>
	</td>
	<td nowrap align="right">
		<input type="text" name="product_<?php echo $productId; ?>" value="<?php echo $number; ?>" size="4" />
	</td>
	<td>
		<div id='star_<?php echo "$productId"; ?>' style="visibility:hidden">&larr;</div>
	</td>
<?PHP
   if (null == $coupon) {
?>
	<td align="right">
		<?php echo $config->getCurrency(), $displayUtil->displayDollars($price); ?>
	</td>
<?php
   }
   else {
?>
	<td align="right">
		<?php echo $config->getCurrency(), $displayUtil->displayDollars($fullPrice); ?>
	</td>
	<td align="right">
		<?php echo $config->getCurrency(), $displayUtil->displayDollars($price); ?>
	</td>
	
<?PHP
   
   }
?>
</tr>	
<?php	
}
?>
<tr>
	<td colspan='5'> 
		<div id='error_message' style="visibility:hidden">
			<b>Please correct the errors highlighted with a &larr;<br />
			Order quantities must be less than <?php echo $config->getMaxProductQuantityPerOrder() + 1 ?>.</b>
		</div>
	</td>
</tr>
</table>

<input type="submit"  value="update cart" /><br /><br />
<!-- <a class="highlight" href="viewCart.php" >don't change</a> -->

</form>
<?php include "storeFooter.php"; ?>
</body>
</html>