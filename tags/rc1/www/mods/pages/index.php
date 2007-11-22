<?php

$page_id=intval($_GET['var1']);
if ($page_id)
{
	$page_info=$db->selectRow("SELECT * FROM ?_pages WHERE page_id=?", $page_id);
	if (!$page_info)
	{
		error404();
	}
}
else
{
	$page_info=$db->selectRow("SELECT * FROM ?_pages WHERE tree_id=?", $core['id']);
}

switch (true)
{
	case (access('add') && $_GET['action']=="add"):
		$mode="add";
		include dirname(__FILE__)."/edit.php";
	break;
	case (access('edit') && $_GET['action']=="edit"):
		$mode="edit";
		include dirname(__FILE__)."/edit.php";
	break;
	case (access('delete') && $_GET['action']=="delete"):
		$mode="delete";
		include dirname(__FILE__)."/edit.php";
	break;
	case (access('read') && !$page_info):
		include dirname(__FILE__)."/list.php";
	break;
	default:
		include dirname(__FILE__)."/show.php";
}
?>