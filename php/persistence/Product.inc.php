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

require_once 'persistence/DAO.inc.php';
require_once 'persistence/MenuItem.inc.php';


/*
* A class to wrap the Product database object.
*
* A product should not be deleted from the database as orders will probably remain 
* that rely on that product, Instead the $display flag should be set to 0 so that the
* product is not displayed on the web-site.
*
*/
class Product extends DAO {

    // A MenuItem matching menuId. Read in by the read() method
    var $menuItem; 
    
    var $menuId; /* Not NULL */
	var $name;	/* Not NULL */
	var $description1;	/* Not NULL */
	var $description2;
	var $type;
	var $cost;	/* in cents, Not NULL */ 
	var $weight;	/* in grams, Not NULL */
	var $graphicImage;	/* Not NULL */
	var $productImage;	/* Not NULL */	
	var $color1;	
	var $color2;
	
	function Product(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = 'Product';
		$this->fields = Array('menuId', 'name', 
                                'description1', 'description2', 
                                'type', 'cost', 'weight', 
                                'graphicImage', 'productImage',  
                                'color1', 'color2');
                                
	   $this->menuItem = &new MenuItem($this->config);
	}
	
	function readForMenuItem($menuId) {   
		$sql = "SELECT * from $this->table WHERE menuId='$menuId'";
		$result = parent::readFromSQL($sql); 
	   if ($result) {
	       $this->menuItem->id = $this->menuId;
	       $result = $this->menuItem->read();  
	   } 
	   return $result;   
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;

		return $result;
	}
	
	function create() {
	   $this->menuItem->id = $this->menuId;
	   $this->menuItem->name = $this->name;
	   $result = $this->menuItem->create();
	   if ($result) {
	       $this->menuId = $this->menuItem->id;
	       $result = parent::create();  
	   }
	   return $result; 
	}
	
	function read() {	   
	   $result = parent::read();
	   if ($result) {
	       $this->menuItem->id = $this->menuId;
	       $result = $this->menuItem->read();  
	   } 
	   return $result;
	}
	
	function update() {
	   $this->menuItem->name = $this->name;
	   $result = $this->menuItem->update();
	   if ($result) {
	       $result = parent::update();  
	   }
	   return $result; 
	}
	
	
			
}


?>