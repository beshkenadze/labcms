<?
$mod_template="edit_forum.tpl";
if ($_SERVER['REQUEST_METHOD']=="POST")
{
	$errors=array();
	$forum_name=trim($_POST['forum_name']);
	if (!$forum_name)
	{
		$errors[]="Не введено название форума";
	}
	if (!count($errors))
	{
		$query=array('forum_name'=>$forum_name,
					'descr'=>$_POST['descr'],
					'closed'=>($_POST['closed']?1:0));
	}
	if ($mode=="new")
	{
		$db->query("INSERT INTO ?_forum_forums SET ?a", $query);
		refresh('ok');
	}
	elseif($mode=="edit")
	{
		$db->query("UPDATE ?_forum_forums SET ?a WHERE forum_id=?", $query, $forum_info['forum_id']);
		refresh('ok');
	}
}
elseif ($mode=="edit")
{
	$smarty->assign(array('forum_name'=>$forum_info['forum_name'],'descr'=>$forum_info['descr'],'closed'=>$forum_info['closed']));
}
elseif ($mode=="delete")
{
	$db->query("DELETE ff, ft, fp FROM ?_forum_forums ff LEFT JOIN ?_forum_themes ft ON ff.forum_id=ft.forum_id LEFT JOIN ?_forum_posts fp ON ft.theme_id=fp.theme_id WHERE ff.forum_id=?", $forum_info['forum_id']);
	refresh('ok');
}
$smarty->assign('errors', $errors);
?>