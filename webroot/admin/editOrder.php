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

require_once '../presentation/CodeRoot.inc.php';

require_once 'adminmodel/EditOrderView.inc.php';

require_once 'business/Config.inc.php';
require_once 'business/ProxyMother.inc.php';

require_once 'persistence/Address.inc.php';
require_once 'persistence/Country.inc.php';
require_once 'persistence/Customer.inc.php';
require_once 'persistence/InvoiceCoupon.inc.php';
require_once 'persistence/Note.inc.php';
require_once 'persistence/Order.inc.php';
require_once 'persistence/OrderHistory.inc.php';
require_once 'persistence/Product.inc.php';

require_once 'util/DisplayUtil.inc.php';


$config = &new Config();
$adminProxy = &ProxyMother::getAdminProxy($config);

$displayUtil = &new DisplayUtil();

$id = $_POST['id'];
if (!$id) {
	$id = $_GET['id'];
}

$listing = $_POST['listing'];
if (!$listing) {
	$listing = $_GET['listing'];	
}
//debug
//$id = 1;

$view = $adminProxy->getOrder($id);

$order = &$view->order;
$customer = &$view->customer;
$address = &$view->address;
		
$country = &new Country($config, $address->countryId);
$country->read();
		

$products = &$view->products;
$quantities = &$view->quantities;

$history = &$view->history;
$notes = &$view->notes;

$coupon = &$view->coupon;

?><html>
<head>
</head>
<body>
<?php include "adminToolbar.php" ?> 
<a href="orderListing.php?status=<?php echo $listing; ?>">Back to order listing</a>
<br />
<a href="../presentation/trackOrder.php?id1=<?php echo $order->id; ?>&id2=<?php echo $order->password; ?>">View invoice</a>
<p>
<form method='post' action='updateOrder.php'>
<input type='hidden' name='id' value="<?php echo $order->id; ?>" />
<input type='hidden' name='listing' value="<?php echo $listing; ?>" />
<table>
<tr>
	<th>Update order status</th>
	<td>
	<select name='status'>
	<?PHP
		foreach ($view->possibleStatus as $status) {
			echo '<option';
			if ($status == $order->status) {
				echo ' selected';	
			}
			echo '>', $status , '</option>';
		}
	?>
	</select>
	</td>
</tr>
<tr>
	<th>Add any note here</th>
	<td><TEXTAREA name="note" cols="30" rows="10"></textarea></td>
</tr>
<tr colspan='2'>
	<td><input type="submit" value="update" /></td>
</tr>
</table>
</form>


<table cellpadding="5" border='1' title="Order Detail">
<tr><th colspan='6'>Order Detail</th></tr>
<tr>
	<th colspan='2'>order ID</th><td colspan='4'><?php echo $order->id ?></td>
</tr>
<tr>
	<th colspan='2'>cost</th><td colspan='4'>$<?php echo $displayUtil->displayDollars($order->cost) ?></td>
</tr>
<tr>
	<th colspan='2'>status</th>
	<td colspan='4'><?php echo $order->status; ?></td>
</tr>
<tr>
	<th colspan='2'>date ordered</th><td colspan='4'><?php echo $displayUtil->displayDate($order->dateOrdered) ?></td>
</tr>


<tr>
	<th rowspan='5'>customer</th>
	<th align="right">name</th>
	<td colspan='4'><?php echo "$customer->salutation $customer->first $customer->middle $customer->last"; ?></td> 
</tr>
<tr>
	<th align="right">email</th>
	<td colspan='4'><?php echo $customer->email; ?></td>
</tr>
<tr>
	<th align="right">phone1</th>
	<td colspan='4'><?php echo $customer->phone1; ?></td>
</tr>
<tr>
	<th align="right">phone2</th>
	<td colspan='4'><?php echo $customer->phone2; ?></td>
</tr>
<tr>
	<th align="right">sale type</th>
	<td colspan='4'><?php echo $view->saleType->type; ?></td>
</tr>


<tr>
	<th colspan='2' rowspan='6'>address</th>
	<td colspan='4'><?php echo $address->street1; ?></td> 
</tr>
<tr>
	<td colspan='4'><?php echo $address->street2; ?></td> 
</tr>
<tr>
	<td colspan='4'><?php echo $address->city; ?></td> 
</tr>
<tr>
	<td colspan='4'><?php echo $address->state; ?></td> 
</tr>
<tr>
	<td colspan='4'><?php echo $address->postcode; ?></td> 
</tr>
<tr>
	<td colspan='4'><?php echo $country->country; ?></td> 
</tr>


<tr>
	<th colspan='2' rowspan='<?php echo count($quantities) + 1;?>' >products ordered</th>
	<th>product name</th>
	<th>quantity</th>
	<th>product cost</th>
	<th>product weight</th>
</tr>
<?php 
foreach ($quantities as $productId => $quantity) {
	$product = $products[$productId];
?>
	<tr>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $quantity; ?></td>
		<td>$<?php echo $displayUtil->displayDollars($product->cost); ?></td>
		<td><?php echo $displayUtil->displayKg($product->weight); ?>kg</td>
	</tr>
<?PHP
}
?>
<?PHP
    if (null != $coupon) {
?>
    <tr>
        <th colspan="2">Coupon used</th>
        <td colspan="4"><?php echo "'", $coupon->code, "' for a ", $coupon->discount, '% discount'; ?></td>
    </tr>
<?PHP
}
?>

<tr>
	<th colspan='2' rowspan='<?php echo count($notes) + 1;?>' >notes</th>
	<th colspan='2'>date</th>
	<th colspan='2'>note</th>
</tr>
<?php 
foreach ($notes as $note) {
?>
	<tr>
		<td colspan='2'><?php echo $displayUtil->displayDate($note->date); ?></td>
		<td colspan='2'><PRE><?php echo $note->note; ?></pre></td>
	</tr>
<?PHP
}
?>

<tr>
	<th colspan='2' rowspan='<?php echo count($history) + 1;?>' >order history</th>
	<th colspan='2'>date</th>
	<th colspan='2'>status</th>
</tr>
<?php 
foreach ($history as $orderHistory) {
?>
	<tr>
		<td colspan='2'><?php echo $displayUtil->displayDate($orderHistory->date); ?></td>
		<td colspan='2'><?php echo $orderHistory->status; ?></td>
	</tr>
<?PHP
}
?>

</table>
</p>
</body>
</html>