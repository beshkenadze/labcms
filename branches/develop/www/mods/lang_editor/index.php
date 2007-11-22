<?php

switch (true)
{
	case($_GET['action']=="del_lang" && isset($_GET['var1']) && access('delete')):
		$mode="delete";
		include dirname(__FILE__)."/edit_lang.php";
	break;
	case($_GET['action']=="edit_lang" && isset($_GET['var1']) && access('edit')):
		$mode="edit";
		include dirname(__FILE__)."/edit_lang.php";
	break;
	case($_GET['action']=="add_lang" && access('add')):
		$mode="add";
		include dirname(__FILE__)."/edit_lang.php";
	break;
	case(isset($_GET['var1']) && access('msg_edit')):
		$mode="edit";
		include dirname(__FILE__)."/translate.php";
	break;
	default:
		include dirname(__FILE__)."/langs.php";
}

$smarty->assign('errors', $errors);
?>