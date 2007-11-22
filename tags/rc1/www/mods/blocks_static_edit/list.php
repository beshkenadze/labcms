<?
if ($_SERVER['REQUEST_METHOD']=='POST' && access('edit'))
{
	$db->query("UPDATE ?_blocks_static SET visible=0");
	if ($_POST['visible']) $db->query("UPDATE ?_blocks_static SET visible=1 WHERE block_id IN (?a)", array_keys($_POST['visible']));
	refresh();
}
$mod_template="list.tpl";
$result=$db->select("SELECT block_id, name, visible FROM ?_blocks_static");
$smarty->assign('blocks', $result);
?>