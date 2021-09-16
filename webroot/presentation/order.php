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

$displayUtil = &new DisplayUtil();
$config = &new Config();
$orderProxy = &ProxyMother::getOrderProxy($config); 
$cart = &Cart::getCart($config);

// read in credit card details
$creditName = htmlspecialchars($_POST['credit_name']);
$creditNumber = htmlspecialchars($_POST['credit_number']);
$creditExpiryMonth = htmlspecialchars($_POST['credit_expiry_month']);
$creditExpiryYear = htmlspecialchars($_POST['credit_expiry_year']);

// shipping details
$shippingRateId = htmlspecialchars($_POST['shipping']);
$order = $orderProxy->createOrder($cart, $creditName, $creditNumber, $creditExpiryMonth, $creditExpiryYear, $shippingRateId);

$id = 0;
$password = 0;

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
	echo $config->getCompanyName(), ' - processing order';
?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
<?php
	if ($order && !($order->isRejected()))  {
		$id = $order->id;
		$password = $order->password;
?>
	<noscript>
		<meta http-equiv="refresh" content="2; URL=<?php echo "trackOrder.php?id1=$id&id2=$password"; ?>">
	</noscript>
	<script language="JavaScript">
		<!--
		var sTargetURL = "<?php echo "trackOrder.php?id1=$id&id2=$password"; ?>";
		
		function doRedirect()
		{
		    setTimeout( "window.location.href = sTargetURL", 2*1000 );
		}
		
		//-->
		</script>
		
		<script language="JavaScript1.1">
		<!--
		function doRedirect()
		{
		    window.location.replace( sTargetURL );
		}
		
		doRedirect();
		
		//-->
	</script>
<?php
	}
?> 
</head>

<body <?php
	if ($order && !($order->isRejected()))  {
		$id = $order->id;
		$password = $order->password;
		echo 'onload="doRedirect()"';
	}
?>  bgcolor="white" lang="EN-AU">
<?PHP
if ($order && !($order->isRejected()))  {
?>
<?php include(Config::getCommercialPrefix() . '/order.html'); ?>
<?PHP
} else {
?>
<?php include "storeTitle.php"; ?>
<table border="0" cellpadding="0" cellspacing="0" width="600"> 
<tr>
	<td>
		We are sorry, there was a problem with the payment. Please contact our service desk for more information. 
	</td>
</tr>
<tr>
	<td>
		To try again please <a class="highlight" href="<?php echo $config->getRootUrl(), '/presentation/confirm.php'; ?>">click here</a>. 
	</td>
</tr>
<tr>
	<td><img src="../images/transparent.gif" alt="" width="600" height="10" /></td>
</tr>
<tr>
	<td>
		Your credit card has not been debited and no payment has been made.
	</td>
</tr>
<?PHP
	if ($order && $order->id) {
?>
<tr>
	<td><img src="../images/transparent.gif" alt="" width="600" height="10" /></td>
</tr>
<tr>
	<td>
		Please quote order number: <?PHP echo $order->id ?> when talking to our service desk.
	</td>
</tr>
</table>
<?PHP
	}
$hideFooterProducts = true;
include "storeFooter.php"; 
}
?>


</body>
</html>