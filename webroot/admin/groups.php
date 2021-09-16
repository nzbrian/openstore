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


$menuArray = $adminProxy->getAllMenus();

?>

<html>
<head>
</head>
<body>
<?php include "adminToolbar.php"; ?>
<table border="1">
<tr>
	<th>name (click to edit)</th>
	<th>menu id</th>
	<th>parent menu </th>
	<th>display?</th>
	<th>small image</th>
	<th>large image</th>
	<th>sale type</th>
</tr>

<?php

$saleTypes = $adminProxy->getAllSaleTypes();
foreach ($menuArray as $menuItem) {
	
	
	$id = $menuItem->id;
	$name = $menuItem->name;
	
	$parentMenuId = $menuItem->parentMenuId;
	$parentMenuItem = null;
	if ($parentMenuId) {
	   $parentMenuItem = $menuArray[$parentMenuId];
	   if ($parentMenuItem && ($parentMenuItem->id != $parentMenuId)) {
	       $parentMenuItem = null;
	   }   
	}
	
	$display = $displayUtil->displayBoolean($menuItem->display);
	$smallMenuImage = $config->getSecureUrl() . $menuItem->smallImage;
	$largeMenuImage = $config->getSecureUrl() . $menuItem->largeImage;
	
	$saleType = $saleTypes[$menuItem->saleTypeId];
	$saleTypeName = $saleType->type;
?>
<tr>
	<td>
		<a href="editGroup.php?id=<?php echo $id; ?>" ><?php echo $name; ?></a>
	</td>
	<td><?php echo $id; ?></td>
	<td>
	   <?php 
    	if ($parentMenuItem) {
    	   echo $parentMenuItem->name;   
    	}
    	if ($parentMenuId) {
    	   echo ' (', $parentMenuId, ')';
    	}
	   ?>
	</td>
	<td><?php echo $display; ?></td>
	<td>
		<img src="<?php echo $smallMenuImage; ?>" width="50" />
	</td>
	<td>
		<img src="<?php echo $largeMenuImage; ?>" width="50" />
	</td>
	<td><?php echo $saleTypeName; ?></td>
</tr>	
<?php	
}
?>

</table>


</body>
</html>