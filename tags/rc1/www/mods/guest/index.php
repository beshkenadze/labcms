<?php

switch (true)
{
	case($_GET['action']=="add" && access('add')):
		$core['nav']['path'][]="";
		$core['nav']['name'][]="добавление сообщения";		$mode="add";
		include dirname(__FILE__)."/edit_post.php";
	break;
	case($_GET['action']=="edit" && access('edit') && $_GET['var1']):
		$core['nav']['path'][]="";
		$core['nav']['name'][]="редактирование сообщения";
		$mode="edit";
		include dirname(__FILE__)."/edit_post.php";
	break;
	case($_GET['action']=="delete" && access('delete') && $_GET['var1']):
		$mode="delete";
		include dirname(__FILE__)."/edit_post.php";
	break;
	default:
		include dirname(__FILE__)."/show.php";
}
?>

