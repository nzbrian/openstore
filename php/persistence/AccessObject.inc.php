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

	
require_once('business/Config.inc.php');

/*
* The base class for all classes that access the database. Should really aggregate this as there is no
* benefit here from inhereitance
*/
class AccessObject {
	
	/*
	 * The database table to use;
	 */
	var $table;
	
	/*
	 * An array of String, containing the column names of the table;
	 */
	var $fields;
	
    var $config;
    
    function AccessObject(&$config) {
        $this->config = &$config;    
    }
	
	function &openDatabase() {
		$db = &mysql_connect($this->config->getDbHost(), $this->config->getDbUser(), $this->config->getDbPassword());			
		mysql_select_db($this->config->getDbUse(), $db);
		return $db;
	}
	
	function closeDatabase(&$link) {
		mysql_close($link);
	}
	
}


?>