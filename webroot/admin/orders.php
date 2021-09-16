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

require_once '../presentation/CodeRoot.inc.php';
require_once 'business/Config.inc.php';

$config = &new Config();
?>
<html>
<head>
</head>
<body>
<?php include "adminToolbar.php"; ?>
<p>
<a href="orderListing.php">All orders that are not 'shipped' or 'closed'</a> <br />
</p>
<p>
Orders have one of the following states:
<ul>
	<li><a href="orderListing.php?status=ordered">ordered</a> - the order has been placed on the website, but no further action has been taken</li>
	<li><a href="orderListing.php?status=processing">processing</a> - the order has been placed on the website and payment is being validated</li>
	<li><a href="orderListing.php?status=accepted">accepted</a> - payment has been accepted</li>
	<li><a href="orderListing.php?status=shipped">shipped</a> - the order has been sent to the customer</li>
	<li><a href="orderListing.php?status=rejected">rejected</a> - payment was not accepted by the bank</li>
	<li><a href="orderListing.php?status=lost">lost</a> - the order has been sent but we have been told by the customer that the package was lost in transit</li>
	<li><a href="orderListing.php?status=returned">returned</a> - the customer has returned the order to us</li>
	<li><a href="orderListing.php?status=closed">closed</a> - the order was rejected, lost or returned. We have done all that we can and now the order is closed</li>
</ul>
</p>
<p>
If you would like to download all orders to excel then click the button below. 
<br />
Downloading all orders can be slow!
<br />
<form method="get" action="<?php echo $config->getSecureUrl() ?>/admin/csv.php">
<INPUT type="submit" value="Download All Orders" />
</form>
</p>
</body>
</html>