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

require_once '../../webroot/CodeRoot.inc.php';
require_once 'business/StockProxy.inc.php';
require_once 'model/Cart.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'persistence/SaleType.inc.php';


class CartTest {

	function CartTest() {
	}
	
	
	
	function createProduct() {
		$product = new Product;
		$product->name = 'test product';
		$product->description1 = 'test description 1';
		$product->cost = "100";
		$product->weight = "200";
		$saleType = StockProxy::getSaleTypeGeneral();
		$product->saleTypeId = $saleType->id;	
		$product->create();
		return $product;
	}

	function addProductToSession() {
		$product = $this->createProduct();		
		$cart = Cart::getCart(new Config());
		$cart->add($product, 1);
		$cart->add($product, 2);
		$cart->store();
	}
}

$cartTest = new CartTest;
$cartTest->addProductToSession();

$cart = Cart::getCart(new Config());

echo "<p>";
print_r($cart->contents);
echo "</p>";

?>