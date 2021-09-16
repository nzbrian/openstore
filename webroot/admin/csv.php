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

require_once 'adminmodel/OrderList.inc.php';
require_once 'adminmodel/OrderProductsList.inc.php';

require_once 'business/Config.inc.php';
require_once 'business/ProxyMother.inc.php';

require_once 'persistence/Address.inc.php';
require_once 'persistence/Country.inc.php';
require_once 'persistence/Customer.inc.php';
require_once 'persistence/Note.inc.php';
require_once 'persistence/Order.inc.php';
require_once 'persistence/OrderProducts.inc.php';
require_once 'persistence/OrderHistory.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'persistence/SaleType.inc.php';

require_once 'util/DisplayUtil.inc.php';


$config = &new Config();
$adminProxy = &ProxyMother::getAdminProxy($config);
$stockProxy = &ProxyMother::getStockProxy($config);

$orders = $adminProxy->getAllOrders();
$saleType = $stockProxy->getSaleTypeGeneral();
$products = $stockProxy->getAllProducts($saleType);

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="orders.csv"');

?>

customer_id, customer_salutation, customer_first, customer_middle, customer_last, customer_email, customer_phone1, customer_phone2, <?php
?> address_id, street1, street2, city, state, postcode, country, <?PHP
?> order_id, cost($), status, dateOrdered, password, <?PHP
	foreach ($products as $product) {
		echo $product->name, '(', $product->id, ')' ,', ';	
	}	
?> saleType
<?PHP
	foreach ($orders as $order) {
		$customer = &new Customer($config, $order->customerId);
		$customer->read();
		
		$address = &new Address($config, $order->addressId);
		$address->read();
		
		$country = &new Country($config, $address->countryId);
		$country->read();
		
		$orderProducts = &new OrderProductsList($config);
		$orderProducts->read('orderId', $order->id);
		
		echo '"', $customer->id, '", "', $customer->salutation, '", "', $customer->first, '", "', $customer->middle, '", "', $customer->last, '", "',$customer->email, '", "',$customer->phone1, '", "',$customer->phone2, '", "';
		echo $address->id, '", "',$address->street1, '", "',$address->street2, '", "',$address->city, '", "',$address->state, '", "',$address->postcode, '", "',$country->name, '", "';
		echo $order->id, '", "',$order->cost / 100, '", "',$order->status, '", "',DisplayUtil::displayDate($order->dateOrdered), '", "',$order->password, '", ';
		
		$productsInOrder = array();
		foreach ($orderProducts->list as $orderProduct) {
			$productsInOrder[$orderProduct->productId] = $orderProduct->number;		
		}
		
		foreach ($products as $product) {
				echo '"', $productsInOrder[$product->id], '", ';	
		}
		echo '"', $saleType->type, '"';
		echo "\n";
	}	
?>

