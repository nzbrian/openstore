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
 * Test script for the customer object
 */

require_once 'business/StockProxy.inc.php';
require_once 'persistence/Customer.inc.php';
require_once 'persistence/SaleType.inc.php';


class CustomerTest {

	/* 
	 * Calls all of the other tests
	 */
	function CustomerTest() {
		$this->testCreate();
		
	}
	
	function testCreate() {
		echo "<br>Creating new Customer <br>";
		
		$customer = $this->create();
		
		echo "<br> Created: <br>";
		print_r(get_object_vars($customer));
		echo "<br>";

		
		$check = new Customer;
		$check->id = $customer->id;
		$check->read();
		echo "<br>checking: <br>";
		print_r(get_object_vars($check));					
	}
	
	function create() {
		$saleType = StockProxy::getSaleTypeGeneral();
		
		$customer = new Customer;
		$customer->first = "first";
		$customer->last = "last";
		$customer->salutation = "Mr";
		$customer->email = "email@";
		$customer->phone1 = "12345678";
		$customer->saleTypeId = $saleType->id;
		$customer->create();
		return $customer;
	}
	

}

new CustomerTest;

?>