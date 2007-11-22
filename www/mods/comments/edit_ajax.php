<?
is_numeric($_POST['comment_id']) ? "" : exit ;
if ((access("edit") || (access("msg_edit") && $user_info['user_id']==$comment_info['user_id'])))
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
			$db->query("UPDATE ?_comments SET msg=? WHERE comment_id=?", $_POST['msg'], $_POST['comment_id']);
		}
	}
}

?>