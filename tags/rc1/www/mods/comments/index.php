<?

switch($_GET['action'])
{
	case("comment_edit"):
		$mode="edit";
		include dirname(__FILE__)."/edit.php";
	break;
	case("comment_delete"):
		$mode="delete";
		include dirname(__FILE__)."/edit.php";
	break;
	case("comment_ajax"):
		$mode="add";
		include dirname(__FILE__)."/ajax.php";
		//$_RESULT["q"]="ok";
		//print_r($_POST);
		exit;
	case("comment_delete_ajax"):
		include dirname(__FILE__)."/delete_ajax.php";
		//print_r($_POST);
		exit;
	case("comment_edit_ajax"):
		include dirname(__FILE__)."/edit_ajax.php";
		//print_r($_POST);
		exit;
	default:
		include dirname(__FILE__)."/comments.php";
	break;
}
?>