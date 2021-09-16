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


require_once 'persistence/ListAO.inc.php';
require_once 'persistence/SaleType.inc.php';


/*
 * public:
 * Represents a list of SaleTypes.
 */
class SaleTypeList extends ListAO {
    
    function SaleTypeList(&$config) {
        parent::ListAO($config);   
    }
	
	/*
	 * protected: call-back from ListAO
	 */
	function &createEmptyObject() {
		return new SaleType($this->config);
	}
}

?>