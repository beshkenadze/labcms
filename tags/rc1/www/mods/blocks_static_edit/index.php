<?
$block_id=intval($_GET['var1']);

$smarty->assign('access_add', access('add'));
$smarty->assign('access_delete',  access('delete'));
$smarty->assign('access_edit',  access('edit'));

switch(true)
{
	case(!$_GET['action'] && $block_id && access('edit')):
		$mode="edit";
		include dirname(__FILE__)."/edit.php";
	break;
	case($_GET['action']=='delete' && $block_id && access('delete')):
		include dirname(__FILE__)."/delete.php";
	break;
	case($_GET['action']=='add' && access('add')):
		$mode="add";
		include dirname(__FILE__)."/edit.php";
	break;
	default:
		include dirname(__FILE__)."/list.php";
	break;
}
?>