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

$config = &new Config();

$stockProxy = &ProxyMother::getStockProxy($config);
$saleType = $stockProxy->getSaleTypeGeneral();

$parentMenuId = $_GET['menuItem'];
$parentMenuItem = null;
if (null == $parentMenuId) {
    $parentMenuId = '';   
}
elseif (0 != strcmp('', $parentMenuId)) {
    $parentMenuId = (int)$parentMenuId;   
    $parentMenuItem = &$stockProxy->getMenuItem($parentMenuId, $saleType);
}
$menuItems = &$stockProxy->getAllMenuItems($saleType, $parentMenuId);


$numberOfColumns = 3;

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - online store';
	if (null != $parentMenuItem) {
	   echo ' - ' . $parentMenuItem->name;   
	}
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<table border='0' cellspacing="15">
<?PHP
    if (null != $parentMenuItem) {
        echo '<div class="paragraphHeader">', $parentMenuItem->name, '</div>';       
    }


	$column = 0;
	$firstRow = true;
	
	$numItems = count($menuItems);
	$itemNumber = 0;
	foreach ($menuItems as $menuItem) {
	    $itemNumber++;
		if ($column == 0) {
			if (!$firstRow) {
				echo '<tr><td><img src="../images/black.gif" alt="" width="150" height="1" /></td>';
				for ($i = 1; $i < $numberOfColumns; $i++) {
					echo '<td></td><td><img src="../images/black.gif" alt="" width="150" height="1" /></td>';	
				}
				echo '</tr>';
			}
			$firstRow = false;
			echo '<tr>';	
		}
?>	
		<td align='center'>
			<a href="viewProduct.php?menuItem=<?php echo $menuItem->id; ?>">
				<img src="<?php echo $config->getRootUrl(), $menuItem->largeImage; ?>" alt="<?php echo $menuItem->name; ?>" height='120' width="53" border="0" /><br />
				<br />
				<?php echo $menuItem->name; ?>
			</a>
		</td>
<?PHP
		if (($itemNumber < $numItems) && ($column < $numberOfColumns - 1)) {
?>
			<td><img src='../images/black.gif' alt='' height='150' width='1' /></td>		
<?php	
		}
		$column++;
		if ($column == $numberOfColumns) {
			echo '</tr>';
			$column = 0;	
		} 
	}
?>

<tr>
	<TD colspan="<?php echo 2 * $numberOfColumns - 1; ?>" align="center">
<?php
    if (null == $parentMenuItem) { 
?>
	    <a class="highlight" href="<?php echo $config->getRootUrl(); ?>/presentation/howDoIOrder.php">how does this work?</a>
<?php	
    }
    else {    
?>    
		<a class="highlight" href="javascript:history.back()">go back</a>
<?php
    }
?>
	</td>
</tr>
</table>
<?php 
//	$hideFooterProducts = true;
	include "storeFooter.php"; 
?>
</body>
</html>