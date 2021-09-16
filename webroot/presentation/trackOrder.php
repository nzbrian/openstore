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
require_once 'persistence/InvoiceItem.inc.php';
require_once 'persistence/InvoiceShipping.inc.php';
require_once 'util/DisplayUtil.inc.php';

$config = &new Config();

$id = $_POST['orderId'];
if (!$id) {
	$id = $_GET['id1'];
}
$password = $_POST['orderPass'];
if (!$password) {
	$password = $_GET['id2'];
}

$displayUtil = &new DisplayUtil();
$orderProxy = &ProxyMother::getOrderProxy($config);

$order = $orderProxy->getOrder($id, $password);
$history = $orderProxy->getOrderHistory($order);
$shipping = $orderProxy->getInvoiceShipping($order);
$items = $orderProxy->getInvoiceItems($order);

//print_r($order);
//print_r($history);


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - order tracking';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<table border="0" cellpadding="0" cellspacing="0" width="600"> 
<?php
if ($order) {
?>
<?php include(Config::getCommercialPrefix() . '/trackOrder.thanks.html'); ?>	
	<tr><td align="left"><span class="paragraphHeader">Order Invoice</span></td></tr>
	<tr>
		<td align="center">
			<table cellpadding="5" cellspacing="0" border="0" width="400">
	
				<tr>
					<th align="left" colspan="2">order reference</th><td colspan='2' align="left"><?php echo $order->id ?></td>
				</tr>
				<tr>
					<th align="left" colspan="2">date ordered</th><td colspan='2' align="left"><?php echo $displayUtil->displayDate($order->dateOrdered) ?></td>
				</tr>
				<tr>
					<th align="left" colspan="2">status</th>
					<td colspan='2' align="left"><?php echo $order->status; ?></td>
				</tr>
				
				<tr>
				    <td colspan="4"><img src="../images/transparent.gif" width="400" height="6" alt="" /></td>
				</tr>
			
				<tr>
					<th align="left" colspan="2">product</th>
					<th colspan="1" align="left">quantity</th>
					<th colspan="1" align="left">cost</th>
				</tr>
				<tr>
				    <td colspan="4"><img src="../images/black.gif" width="400" height="1" alt="" /></td>
				</tr>
				<?PHP
					foreach($items as $item) {
				?>  
				<tr>
				    <td colspan="2" align="left"><?php echo $item->name; ?></td>
				    <td colspan="1" align="left"><?php echo $item->number; ?></td>
				    <td colspan="1" align="left" valign="top"><?php echo $config->getCurrency(), $displayUtil->displayDollars($item->totalCost); ?></td>
				</tr>	
				<?php    
					}
				?>
	            <tr>
	               <td align="left" width="50%" colspan="2">shipping - <?php echo $shipping->name; ?> (around <?php echo $shipping->expectedDaysTaken; ?> business days transit)</td>
	               <td colspan="1"></td>
	               <td colspan="1" align="left" valign="top"><?php echo $config->getCurrency(), $displayUtil->displayDollars($shipping->cost); ?></td>
	            </tr>
				
				<tr>
				    <td colspan="4"><img src="../images/black.gif" width="400" height="1" alt="" /></td>
				</tr>
				<tr>
					<th colspan="1" align="left">total cost</th>
					<td></td>
					<td></td>
					<th colspan="1" align="left"><?php echo $config->getCurrency(), $displayUtil->displayDollars($order->cost) ?></th>
				</tr>
				<tr>
				    <td colspan="4"><img src="../images/black.gif" width="400" height="1" alt="" /></td>
				</tr>
				<tr>
				    <td colspan="4" align="left">All prices include GST at 10%</left>
				<tr>
				    <td colspan="4"><img src="../images/transparent.gif" width="400" height="30" alt="" /></td>
				</tr>
                <tr>
                	<th colspan="1" rowspan="<?php echo count($history) + 1;?>" valign="top" align="left">order history</th>
                	<th colspan="2" align="left">date</th>
                	<th colspan="1" align="left">status</th>
                </tr>
                <?php 
                foreach ($history as $orderHistory) {
                ?>
                	<tr>
                		<td colspan="2" align="left"><?php echo $displayUtil->displayDate($orderHistory->date); ?></td>
                		<td colspan="1" align="left"><?php echo $orderHistory->status; ?></td>
                	</tr>
                <?PHP
                }
                ?>
			
			</table>
		</td>
	</tr>
<?php include(Config::getCommercialPrefix() . '/trackOrder.address.html'); ?>	
<?php
}
else {
?>
	<tr>
		<td>
			Sorry there was a problem with that order. 
			Please contact customer support for further assistance.
		</td>
	</tr>
<?PHP
}
?>
</table>
<?php 
include "storeFooter.php"; 
?>
</body>
</html>