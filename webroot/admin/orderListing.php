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

require_once '../presentation/CodeRoot.inc.php';

require_once 'adminmodel/OrderView.inc.php';

require_once 'business/Config.inc.php';
require_once 'business/ProxyMother.inc.php';

require_once 'util/DisplayUtil.inc.php';


$config = &new Config();
$adminProxy = &ProxyMother::getAdminProxy($config);

$displayUtil = &new DisplayUtil();

setlocale(LC_ALL, 'en_AU');

$requestedStatus = $_GET['status'];

$views = NULL;
if ($requestedStatus) {
	$views = $adminProxy->getOrderViews($requestedStatus);
}
else {
	$views = $adminProxy->getAllOpenOrderViews();
}
?><html>
<head>
</head>
<body>
<?php include "adminToolbar.php"; ?>
<table border="1">
<tr>
	<th>order ID</th>
	<th>date ordered</th>
	<th>status</th>
	<th>cost</th>
	<th>customer (last name, first name)</th>
	<th>address</th>
</tr>
<?PHP
foreach ($views as $view) {
	$cost = $displayUtil->displayDollars($view->cost);
	$date = $displayUtil->displayDate($view->dateOrdered);
?>
	<tr>
		<td><a href="editOrder.php?id=<?php echo $view->id; ?>&listing=<?php echo $requestedStatus; ?>"><?php echo $view->id; ?></a></td>
		<td><?php echo $date; ?></td>
		<td><?php echo $view->status; ?></td>
		<td>$<?php echo $cost; ?></td>
		<td><?php echo $view->last, ', ', $view->first; ?></td>
		<td><?php echo $view->street1, ', ', $view->city, ', ', $view->state, ', ', $view->country; ?></td>
	</tr>
<?PHP
}
?>
</table>
</body>
</html>
