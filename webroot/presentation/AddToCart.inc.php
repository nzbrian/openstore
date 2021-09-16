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


require_once 'business/ProxyMother.inc.php';
require_once 'model/Cart.inc.php';
require_once 'persistence/Coupon.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'persistence/SaleType.inc.php';


$cart = &Cart::getCart($config);
$stockProxy = &ProxyMother::getStockProxy($config);
if (($_POST['emptyCart'] == 'true') || ($_GET['emptyCart'] == 'true')) {
	$cart->contents = array();	
}

$saleType = $stockProxy->getSaleTypeGeneral();
foreach($_POST as $key=>$value) {
	$tok = strtok($key, '_');
	if ($tok == 'product') {
		$tok = strtok('_');
		if ($tok) {
			$productId = (int)$tok;
			$product = &$stockProxy->getAProduct($productId, $saleType);
			$amount = (int)$value;
			if ($product && $amount) {
				$cart->add($product, $amount);
			}
		}
	}	
}
$updateCoupon = $_POST['updateCoupon'];
if (0 == strcmp($updateCoupon, 'true')) {
    $requestedCoupon = $_POST['coupon'];
//    echo "updating coupon to be = ", $requestedCoupon;
    $cart->coupon = &$stockProxy->getCoupon($requestedCoupon);
}
$cart->store();

?>