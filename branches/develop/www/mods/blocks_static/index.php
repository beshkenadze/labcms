<?php
$mod_template="";
$results=$db->select("SELECT block_id, data FROM ?_blocks_static WHERE visible=1");
foreach ($results as $result)
{
	$smarty->assign('_module_blocks_static_'.$result['block_id'], $result['data']);
}
?>