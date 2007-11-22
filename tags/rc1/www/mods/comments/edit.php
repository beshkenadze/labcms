<?
$mod_template="show.tpl";
is_numeric($_GET['var1']) ? "" : exit ;
$comment_info=$db->selectRow("SELECT comment_id, module_id, item_id, c.user_id, name,  msg, login FROM ?_comments c LEFT JOIN ?_users u ON c.user_id=u.user_id WHERE comment_id=?", $_GET['var1']);
if ($mode=="edit" && (access("edit") || (access("msg_edit") && $user_info['user_id']==$comment_info['user_id'])))
{
	if ($_SERVER['REQUEST_METHOD']=="POST")
	{
		$errors=array();
		$_POST['msg']=trim($_POST['msg']);

		if (empty($_POST['msg']))
		{
			$errors[]="Не введено сообщение";
		}

		if (!count($errors))
		{
			$db->query("UPDATE ?_comments SET msg=? WHERE comment_id=?", $_POST['msg'], $_GET['var1']);
			refresh("", $_POST['return']);
		}
	}

	$core['nav']['path'][]="";
	$core['nav']['name'][]="редактирование комментария";

	$smarty->assign("mode", $mode);
	$comment=array();
	$comment['name']=$comment_info['login'] ? $comment_info['login'] : $comment_info['name'];
	if (!count($errors)) $comment['msg']=$comment_info['msg'];
	$smarty->assign($comment);
	$smarty->assign("access_edit", 1);
	$smarty->assign("errors", $errors);
}
if ($mode=="delete" && (access("delete") || (access("msg_delete") && $user_info['user_id']==$comment_info['user_id'])))
{
	$db->query("DELETE FROM ?_comments WHERE comment_id=?", $_GET['var1']);
	refresh("",$_GET['return']);
}
?>