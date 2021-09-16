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

require_once 'persistence/DAO.inc.php';

/*
 * A class used to create a view on the database - ie is read using a JOIN.
 * This class represents an Order with some user and address details.
 * This class should only be read from the database, and it should only be read by an OrderViewList.
 */
 class OrderView extends DAO {
 	
 	var $cost;	
	var $status; 
	var $dateOrdered; 
	var $customerId;	
	var $first;
	var $last;
	var $addressId;	
	var $street1;
	var $city;
	var $state;
	var $country;
	
	function OrderView(&$config) {
        parent::DAO($config);
		$this->table = 'AnOrder';
		$this->fields = Array('cost', 'status', 'dateOrdered',
							'customerId', 'first', 'last',
							'addressId', 'street1', 'city', 'state', 'country');
	}
 }
 
?>