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


// This is the bit where you configure where the rest of the code lives

// Change this to be like the comment below when you move the rest of the php code out of the webroot
//ini_set('include_path', '.:/<coderoot>/php:/<coderoot>'); 
ini_set('include_path', '.:../../php:../..'); 

// Other ini_set's are included here with the rest of the configuration and the error logging
require_once 'business/Config.inc.php';

?>