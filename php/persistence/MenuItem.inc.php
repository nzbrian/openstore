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


/*
* A class to wrap the MenuItem database object.
*
* A product or MenuItem should not be deleted from the database as orders will probably remain 
* that rely on that product, Instead the $display flag should be set to 0 so that the
* product is not displayed on the web-site.
*
*/
class MenuItem extends DAO {

    var $parentMenuId;
	var $name;	/* Not NULL */
	var $smallImage;	/* Not NULL */
	var $largeImage;	/* Not NULL */
	var $saleTypeId;	/* Not NULL */
	var $display;	/* 0=don't display, 1=display, Not NULL */
	
	function MenuItem(&$config, $id = NULL) {
        parent::DAO($config, $id);
		$this->table = 'MenuItem';
		$this->fields = Array('parentMenuId', 'name', 'smallImage', 'largeImage', 'saleTypeId', 'display');
	}
	
	/*
	 * Checks that compulsory fields are filled in.
	 * Returns null iff all not null fields are not null, otherwise returns the variable name that is invalid.
	 */
	function validate() {
		$result = null;
		
		if ( !$this->name || (""== trim($this->name)) ) {
			$result = "name";
		}
		elseif ( !$this->smallImage || (""== trim($this->smallImage)) ) {
			$result = "smallImage";
		}
		elseif ( !$this->largeImage || (""== trim($this->largeImage)) ) {
			$result = "largeImage";
		}
		elseif ( !$this->saleTypeId || (""== trim($this->saleTypeId)) ) {
			$result = "saleTypeId";
		}
		elseif ( !$this->display || (""== trim($this->display)) ) {
			$result = "display";
		}
		
		return $result;
	}
	
			
}


?>