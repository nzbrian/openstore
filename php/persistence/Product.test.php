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


/*
 * Test script for the Product object
 */
require_once '../../webroot/presentation/CodeRoot.inc.php';
 
require_once 'persistence/business/StockProxy.inc.php';
require_once 'persistence/presentation/Product.inc.php';
require_once 'persistence/presentation/SaleType.inc.php';
require_once 'persistence/presentation/Customer.inc.php';


class ProductTest {

	/* 
	 * Calls all of the other tests
	 */
	function ProductTest() {
	//	session_start();	
	}
	
	function testCreate() {
		echo "<br>Creating new Product <br>";
		$product = $this->create();
		print_r(get_object_vars($product));
		echo "<br>Checking<br>";
		$check = new Product();
		$check->id = $product->id;
		$check->read();
		print_r(get_object_vars($check));
		
	}
	
	function create() {
		$product = new Product;
		$product->name = 'name';
		$product->description1 = 'description 1';
		$product->cost = "200";
		$product->weight = "300";
		$saleType = StockProxy::getSaleTypeGeneral();
		$product->saleTypeId = $saleType->id;	
		$product->show = 1;
		$product->create();
		return $product;
	}
	

}

$productTest = new ProductTest();

$productTest->testCreate();

?>