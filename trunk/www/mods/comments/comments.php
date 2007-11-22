<?
$mod_template="";

if ($_SERVER['REQUEST_METHOD']=="POST" && access("add") && isset($_POST['msg']))
{

	if ($_POST['name']) {sleep(20); exit();} //если постит робот, то посылаем его нафиг
	$_POST['name']=$_POST[$config['catcher']];
	unset($_POST[$config['catcher']]);
	$msg=trim($_POST['msg']);
	$name=trim($_POST['name']);
	$email=trim($_POST['email']);

	$error=array();
	if (!$msg)
	{
		$error[]="Введите комментарий";
	}
	if(strlen($msg) < 2) {
		$error[]="Слишком короткий комментарий";
	}
	if (!$name)
	{
		$error[]="Введите имя";
	}
	elseif(empty($user_info['login']))
	{
		$result=$db->selectCell("SELECT COUNT(login) FROM ?_users WHERE login=?", $_POST['name']);
		if ($result)
		{
			$error[]="Пользователь с таким именем уже зарегистрирован!";
		}
	}
	if (!count($error))
	{
		$query=array('module_id'=>$core['comment']['module_id'],
						'item_id'=>$core['comment']['item_id'],
						'msg'=>$msg);
		if ($user_info['user_id']>0)
		{
			$query['user_id']=$user_info['user_id'];
		}
		else
		{
			$query['email']=$email;
			$query['name']=$name;
		}
		$db->query("INSERT INTO ?_comments SET ?a, putdate=NOW(), ip=INET_ATON(?)", $query, $_SERVER['REMOTE_ADDR']);
			if ($config['comments_email_notify'] && $config['admin_mail'])
			{
				$mail = new htmlMimeMail();
				if ($user_info['user_id']>0)
					$mail->setText($user_info['login']."(".$user_info['email'].") оставил комментарий к материалу: $titlepage\r\n".$_POST['msg']."\r\nhttp://".$_SERVER["SERVER_NAME"].$_POST['return']);
				else
					$mail->setText($query['name']."(".$query['email'].") оставил комментарий к материалу: $titlepage\r\n".$_POST['msg']."\r\nhttp://".$_SERVER["SERVER_NAME"].$_POST['return']);
				$mail->setFrom('Робот комментариев <comments@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"].">"));
				$mail->setReturnPath('comments@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"]));
				$mail->setSubject('Новый комментарий на сайте '.$_SERVER["SERVER_NAME"]);
				$mail->send(array($config['admin_mail']));
			}
		refresh('',$_POST['return']);
	}
	$smarty->assign('errors', $error);
}

 //////////////////////
 //	$core['comment']['module_id'] - id текущего компонента
 //	$core['comment']['item_id'] - id айтема раздела (или массив, если надо вывести количество комментариев)
 /////////////////////
if (is_numeric($core['comment']['item_id']))
{
	$mod_template="show.tpl";
	$result=$db->select("SELECT u.user_id, login, u.email as u_email, name, c.email as c_email, putdate, msg, comment_id, INET_NTOA(ip) as ip FROM ?_comments c LEFT JOIN ?_users u ON c.user_id=u.user_id WHERE module_id=? AND item_id=? ORDER BY putdate ASC", $core['comment']['module_id'], $core['comment']['item_id']);
	if (count($result))
	{
		foreach($result as $comms)
		{
			if ($comms['user_id'])
			{
				$c_name=text_string($comms['login']);
				$c_email=text_string($comms['u_email']);
			}
			else
			{
				$c_name=text_string($comms['name']);
				$c_email=text_string($comms['c_email']);
			}
			$c_msg=bbcode_all($comms['msg']);
			$access_edit=((access('edit') || (access('msg_edit') && $user_info['user_id']==$comms['user_id'] && $user_info['group_id']>0))? true: false);
			$access_delete=((access('delete') || (access('msg_delete') && $user_info['user_id']==$comms['user_id'] && $user_info['group_id']>0))? true: false);
			//print_r($comms);
			$smarty->append('comments',array('name'=>$c_name, 'email'=>$c_email, 'putdate'=>$comms['putdate'], 'msg'=>$c_msg, 'id'=>$comms['comment_id'], 'ip'=>$comms['ip'], 'access_edit'=>$access_edit, 'access_delete'=>$access_delete));
		}
	}

$smarty->assign('access_add', access('add'));

}
if (is_array($core['comment']['item_id']))
{
if (!file_exists($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$config['skin']."/".$core['inc']['module']."comment_count.tpl"))
$comment_count_tpl=file_get_contents($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH."default/".$core['inc']['module']."comment_count.tpl");
else
$comment_count_tpl=file_get_contents($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$config['skin']."/".$core['inc']['module']."comment_count.tpl");
$null_comment=array();
foreach ($core['comment']['item_id'] as $tmp)
{
$null_comment['<!--comment'.$tmp.'-->']=str_replace('COMMENTS', 0, $comment_count_tpl);
}

$result=$db->selectCol("SELECT CONCAT('<!--comment',item_id,'-->') AS ARRAY_KEY, REPLACE('$comment_count_tpl', 'COMMENTS',  count(item_id)) FROM ?_comments WHERE module_id=? AND item_id IN (?a) GROUP BY item_id", $core['comment']['module_id'], $core['comment']['item_id']);

$result=array_merge($null_comment, $result);
$smarty->_tpl_vars['_component']=str_replace(array_keys($result), $result, $smarty->_tpl_vars['_component']);
}


?>