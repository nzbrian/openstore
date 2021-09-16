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

require_once 'CodeRoot.inc.php';
require_once 'business/Config.inc.php';

$config = &new Config();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>
<?php 
echo $config->getCompanyName(), ' - about';

?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<link href="../<?php echo Config::getCommercialPrefix(); ?>/openstore.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="white" lang="EN-AU">
<?php include "storeTitle.php"; ?>
<?php include Config::getCommercialPrefix() . '/about.html'?>
<?php include "storeFooter.php"; ?>
</body>
</html>

