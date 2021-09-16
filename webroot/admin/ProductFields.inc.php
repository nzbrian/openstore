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

require_once 'util/HTTPUtil.inc.php';
$httpUtil = &new HTTPUtil();
$menuItem = &$product->menuItem; 
$allSaleTypes = &$adminProxy->getAllSaleTypes();
$allMenus = &$adminProxy->getAllMenus();
$allMenus[0] = '';
?>
<table border="0">
	<TR>
		<td>product name</td>
		<td><?php echo $httpUtil->getInput('name', $product); ?></td>
	</TR>
	<TR>
		<td>cost in cents</td>
		<td><?php echo  $httpUtil->getInput('cost', $product); ?></td>
	</TR>
	<TR>
		<td>weight in grams</td>
		<td><?php echo  $httpUtil->getInput('weight', $product); ?></td>
	</TR>
	<TR>
		<td>display?</td>
		<td><?php  echo $httpUtil->getInputChoice('display', $menuItem, array(1=>'yes', 0=>'no')); ?></td>
	</TR>
	<TR>
		<td>description 1</td>
		<td><?php  echo $httpUtil->getInputArea('description1', $product, 100, 10); ?></td>
	</TR>
	<TR>
		<td>description 2</td>
		<td><?php  echo $httpUtil->getInputArea('description2', $product, 100, 10); ?></td>
	</TR>
	<TR>
		<td>product type</td>
		<td><?php  echo $httpUtil->getInput('type', $product); ?></td>
	</TR>
	<TR>
		<td valign="top">product image</td>
		<td>
			<?php  echo $httpUtil->getInput('productImage', $product, 100); ?> <br />
			<img src="<?php echo $config->getSecureUrl(), $product->productImage; ?>" />
		</td>
	</TR>
	<TR>
		<td valign="top">graphic image</td>
		<td>
			<?php  echo $httpUtil->getInput('graphicImage', $product, 100); ?> <br />
			<img src="<?php echo $config->getSecureUrl(), $product->graphicImage; ?>" />
		</td>
	</TR>
	<TR>
		<td valign="top">small menu image</td>
		<td>
			<?php  echo $httpUtil->getInput('smallImage', $menuItem, 100); ?> <br />
			<img src="<?php echo $config->getSecureUrl(), $menuItem->smallImage; ?>" />
		</td>
	</TR>
	<TR>
		<td valign="top">large menu image</td>
		<td>
			<?php  echo $httpUtil->getInput('largeImage', $menuItem, 100); ?> <br />
			<img src="<?php echo $config->getSecureUrl(), $menuItem->largeImage; ?>" />
		</td>
	</TR>
	<TR>
		<td valign="top">color 1</td>
		<td bgcolor="<?php echo $product->color1; ?>">
			<?php  echo $httpUtil->getInput('color1', $product, 100); ?> <br />
		</td>
	</TR>
	<TR>
		<td valign="top">color 2</td>
		<td bgcolor="<?php echo $product->color2; ?>">
			<?php  echo $httpUtil->getInput('color2', $product, 100); ?> <br />
		</td>
	</TR>
	<TR>
		<td>sale type</td>
		<td><?php  echo $httpUtil->getObjectChoice('saleTypeId', $menuItem, $allSaleTypes, 'type'); ?></td>
	</TR>
	<TR>
		<td>parent menu</td>
		<td><?php  echo $httpUtil->getObjectChoice('parentMenuId', $menuItem, $allMenus, 'name'); ?></td>
	</TR>
</tr>
</table>