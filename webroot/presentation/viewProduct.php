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
require_once 'persistence/Product.inc.php';
require_once 'util/DisplayUtil.inc.php';

$id = '';
$menuId = '';
if (array_key_exists('product', $_GET)) {
    $id = $_GET['product'];
}
else {
    $menuId = $_GET['menuItem'];
}

$displayUtil = &new DisplayUtil();
$config = &new Config();
$stockProxy = &ProxyMother::getStockProxy($config);
$saleType = $stockProxy->getSaleTypeGeneral();
$product = null;
if ($id) {
    $id = (int)$id;
    $product = &$stockProxy->getAProduct($id, $saleType);
}
else {
    $menuId = (int)$menuId;
    $product = &$stockProxy->getAProductFromMenuId($menuId, $saleType);
    if (null == $product) {
        include('index.php');
        return(0);      
    } 
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - ', $product->name;
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<script src="../js/openstore.js" type="text/javascript" language="javascript1.2"></script>
<SCRIPT type="text/javascript" language="javascript">
<!--
	
	function validate(form) {
		return checkIntLessThan(getReference('product_<?php echo $product->id; ?>'), getReference('errorMessage'), false, <?php echo Config::getMaxProductQuantityPerOrder() + 1; ?>);
	}
-->
</SCRIPT>
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<form method="POST" action="viewCart.php" onsubmit="return validate(this)">
<table border="0" cellpadding="0" cellspacing="0" width="600"> 
	<tr>
		<td rowspan='9' valign="top"><img src="<?php echo '..' , $product->graphicImage; ?>" width="150" height="200" alt="<?php echo $product->name; ?>" /></td>
		<td rowspan='9'><img src="../images/transparent.gif" alt="" width="30" height="1" /></td>
		<td align="left">
			<span class="productName" style="color:#<?php echo $product->color1; ?>"><?php echo $product->name; ?></span> <span class="productType" style="color:#<?php echo $product->color2; ?>"><?php echo $product->type; ?></span>
		</td>
		<td rowspan='9'><img src="../images/transparent.gif" alt="" width="30" height="1" /></td>
		<td rowspan='9' valign="top"><img src="<?php echo '..', $product->productImage; ?>" alt="<?php echo $product->name; ?>" /></td>
	</tr>
	<tr>
		<td><img src="../images/transparent.gif" alt="" width="1" height="6" /></td>
	</tr>
	<tr>
		<td align="left"><?php echo $product->description1; ?></td>
	</tr>
	<tr>
		<td><img src="../images/transparent.gif" alt="" width="1" height="6" /></td>
	</tr>
	<tr>
		<td align="left"><?php echo $product->description2; ?></td>
	</tr>
	<tr>
		<td><img src="../images/transparent.gif" alt="" width="1" height="6" /></td>
	</tr>
	<tr>
		<td align="left"><?php echo $config->getCurrency(), $displayUtil->displayDollars($product->cost); ?></td>
	</tr>
	<tr>
		<td><img src="../images/transparent.gif" alt="" width="1" height="1" /></td>
	</tr>
	<tr>
		<td nowrap valign="bottom" align="right">
			<input type="text" size="2" name="product_<?php echo $product->id; ?>" value="1" />
			<input type="submit" value="add to basket" />
			<div id='errorMessage' style="visibility:hidden">Please enter a number less than <?php echo $config->getMaxProductQuantityPerOrder() + 1; ?> in the provided field!</div>
		</td>
	</tr>	
</table>
</form>
<?php include "storeFooter.php"; ?>

</body>
</html>