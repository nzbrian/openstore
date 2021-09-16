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


// show existing products with edit links
require_once '../presentation/CodeRoot.inc.php';
require_once 'business/Config.inc.php';
require_once 'business/ProxyMother.inc.php';
require_once 'model/CouponList.inc.php';
require_once 'persistence/Coupon.inc.php';
require_once 'util/DisplayUtil.inc.php';

$displayUtil = &new DisplayUtil();
$config = &new Config();
$adminProxy = &ProxyMother::getAdminProxy($config);


$couponArray = $adminProxy->getAllCoupons();

?>

<html>
<head>
</head>
<body>
<?php include "adminToolbar.php"; ?>
<table border="1">
<tr>
	<th>coupon code (click to edit)</th>
	<th>discount</th>
	<th>start date</th>
	<th>end date</th>
</tr>

<?php

foreach ($couponArray as $coupon) {
	
//	print_r($product);
	
	$id = $coupon->id;
	$code = $coupon->code;
	$discount = $coupon->discount;
	$start = DisplayUtil::displayDate($coupon->start);
	$end = DisplayUtil::displayDate($coupon->end);
?>
<tr>
	<td>
		<a href="editCoupon.php?id=<?php echo $id; ?>" ><?php echo $code; ?></a>
	</td>
	<td><a href="editCoupon.php?id=<?php echo $id; ?>" ><?php echo $discount; ?>%</a></td>
	<td><?php echo $start; ?></td>
	<td><?php echo $end; ?></td>
</tr>	
<?php	
}
?>

</table>


</body>
</html>