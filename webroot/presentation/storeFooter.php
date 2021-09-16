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

require_once 'business/ProxyMother.inc.php';
require_once 'business/StockProxy.inc.php';
require_once 'model/Cart.inc.php';

	
$footerMenuItems = array();
$spacerWidth = 400;

if (!$hideFooterProducts) {
    $stockProxy = &ProxyMother::getStockProxy($config);
	$saleType = $stockProxy->getSaleTypeGeneral();
	$footerMenuItems = &$stockProxy->getAllMenuItems($saleType);
}
?>
</td></tr>
<tr>
	<td><img src="../images/transparent.gif" alt="" width="600" height="10" /></td>
</tr>
</table>
<table border="0" cellpadding="1" cellspacing="0" width="1">
<tr>
	<td bgcolor="#555555" colspan="4"><img src="../images/transparent.gif" alt="" width="600" height="10" /></td>
</tr>
<tr>
	<td colspan="4"><img src="../images/transparent.gif" alt="" width="600" height="1" /></td>
</tr>
<tr>
	<td bgcolor="#000000" height="60" valign="bottom" align="left">
<?PHP
	foreach ($footerMenuItems as $menuItem) {
		$spacerWidth -= 24;
		$image = '..' . $menuItem->smallImage;
		$name = $menuItem->name;
		$url = $config->getRootUrl() . '/presentation/viewProduct.php?menuItem=' . $menuItem->id
?><a href="<?php echo $url; ?>" title="<?php echo $name; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" height="50" width="22" border="0" /></a><?PHP

	}
		
?>	</td>
	<td bgcolor="#000000"><img src="../images/transparent.gif" border="0" height="1" width="<?php echo $spacerWidth; ?>" alt="" /></td>
	
	<td bgcolor="#000000" valign="bottom" width="1" align="center">
		<a class="black" style="text-align: center" href="<?php echo $config->getRootUrl(); ?>/presentation/viewCart.php"><span style="font-size: 15px; text-align: center" >&nbsp;&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;</span><br />&nbsp;&nbsp;&nbsp;view&nbsp;&nbsp;&nbsp;<br />&nbsp;basket&nbsp;</a>
	</td>
	<td bgcolor="#000000" valign="bottom" width="1" align="center">
		<a class="black" style="text-align: center" href="<?php echo $config->getRootUrl(); ?>/presentation/checkout.php"><span style="font-size: 15px; text-align: center">&nbsp;&nbsp;$&nbsp;&nbsp;</span><br />check<br />&nbsp;&nbsp;out&nbsp;&nbsp;</a>
	</td>
</tr>
</table>
</center>