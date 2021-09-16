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


// show existing products with edit links
require_once '../presentation/CodeRoot.inc.php';
require_once 'business/Config.inc.php';
require_once 'business/ProxyMother.inc.php';
require_once 'model/ProductList.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'util/DisplayUtil.inc.php';

$displayUtil = &new DisplayUtil();
$config = &new Config();
$adminProxy = &ProxyMother::getAdminProxy($config);


$productArray = $adminProxy->getAllProducts();

?>

<html>
<head>
</head>
<body>
<?php include "adminToolbar.php"; ?>
<table border="1">
<tr>
	<th>product name (click to edit)</th>
	<th>cost</th>
	<th>weight</th>
	<th>display?</th>
	<th>description 1</th>
	<th>description 2</th>
	<th>product type</th>
	<th>product image</th>
	<th>graphic image</th>
	<th>small menu image</th>
	<th>large menu image</th>
	<th>color1</th>
	<th>color2</th>
	<th>sale type</th>
</tr>

<?php

$saleTypes = $adminProxy->getAllSaleTypes();
foreach ($productArray as $product) {
	
//	print_r($product);
	
	$id = &$product->id;
	$name = &$product->name;
	$cost = $displayUtil->displayDollars($product->cost);
	$weight = $displayUtil->displayKg($product->weight);
	$display = $displayUtil->displayBoolean($product->menuItem->display) ;
	
	$description1 = &$product->description1;
	$description2 = &$product->description2;
	$type = &$product->type;
	$productImage = $config->getSecureUrl() . $product->productImage;
	$graphicImage = $config->getSecureUrl() . $product->graphicImage;
	$smallMenuImage = $config->getSecureUrl() . $product->menuItem->smallImage;
	$largeMenuImage = $config->getSecureUrl() . $product->menuItem->largeImage;
	
	$color1 = &$product->color1;
	$color2 = &$product->color2;
	
	$saleType = $saleTypes[$product->menuItem->saleTypeId];
	$saleTypeName = $saleType->type;
?>
<tr>
	<td>
		<a href="editProduct.php?id=<?php echo $id; ?>" ><?php echo $name; ?></a>
	</td>
	<td>$<?php echo $cost; ?></td>
	<td><?php echo $weight; ?> kg</td>
	<td><?php echo $display; ?></td>
	<td><?php echo $description1; ?></td>
	<td><?php echo $description2; ?></td>
	<td><?php echo $type; ?></td>
	<td>
		<img src="<?php echo $productImage; ?>" width="50" />
	</td>
	<td>
		<img src="<?php echo $graphicImage; ?>" width="50" />
	</td>
	<td>
		<img src="<?php echo $smallMenuImage; ?>" width="50" />
	</td>
	<td>
		<img src="<?php echo $largeMenuImage; ?>" width="50" />
	</td>
	<td bgcolor="<?php echo $color1; ?>"><?php echo $color1; ?></td>
	<td bgcolor="<?php echo $color2; ?>"><?php echo $color2; ?></td>
	<td><?php echo $saleTypeName; ?></td>
</tr>	
<?php	
}
?>

</table>


</body>
</html>