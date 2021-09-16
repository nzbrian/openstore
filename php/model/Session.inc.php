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


require_once 'business/Config.inc.php';

$SessionActive = false;

class Session {
	
    var $config;
    
	function Session(&$config) {
        $this->config = &$config;
		global $SessionActive;
		if (!$SessionActive) {
            session_save_path($this->config->getSessionSavePath());
            session_name($this->config->getSessionName());
			session_start();
			$SessionActive = true;
			
//			echo "<p>Session: calling session_start</p>";
		}	
		else {
//			echo "<p>Session: not calling session_start</p>";
		}
	}
	
	function &get($key) {
		return $_SESSION[$key];
	}
	
	function set($key, &$value) {
		$_SESSION[$key] = &$value;
	}
}


?>