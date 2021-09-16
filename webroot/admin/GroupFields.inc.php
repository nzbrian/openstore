<?PHP
require_once 'util/HTTPUtil.inc.php';
$httpUtil = &new HTTPUtil();

$allMenus = &$adminProxy->getAllMenus();
$allMenus[0] = '';

$allSaleTypes = &$adminProxy->getAllSaleTypes();

?>
<table border="0">
	<TR>
		<td>name</td>
		<td><?php echo $httpUtil->getInput('name', $menuItem); ?></td>
	</TR>
	<TR>
		<td>parent menu</td>
		<td><?php  echo $httpUtil->getObjectChoice('parentMenuId', $menuItem, $allMenus, 'name'); ?></td>
	</TR>
	<TR>
		<td>display?</td>
		<td><?php  echo $httpUtil->getInputChoice('display', $menuItem, array(1=>'yes', 0=>'no')); ?></td>
	</TR>
	<TR>
		<td valign="top">small image</td>
		<td>
			<?php  echo $httpUtil->getInput('smallImage', $menuItem, 100); ?> <br />
			<img src="<?php echo $config->getSecureUrl(), $menuItem->smallImage; ?>" />
		</td>
	</TR>
	<TR>
		<td valign="top">large image</td>
		<td>
			<?php  echo $httpUtil->getInput('largeImage', $menuItem, 100); ?> <br />
			<img src="<?php echo $config->getSecureUrl(), $menuItem->largeImage; ?>" />
		</td>
	</TR>
	<TR>
		<td>sale type</td>
		<td><?php  echo $httpUtil->getObjectChoice('saleTypeId', $menuItem, $allSaleTypes, 'type'); ?></td>
	</TR>
</tr>
</table>