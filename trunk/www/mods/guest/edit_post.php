<?
$titlepage=_lang("Гостевая книга. Добавление сообщения");
$smarty->assign('content_name', $titlepage);
if ($_SERVER['REQUEST_METHOD']=="POST")
{	
	if ($_POST['name']) {sleep(20); exit();} 
	$_POST['name']=$_POST[$config['catcher']];
	unset($_POST[$config['catcher']]);
	$errors=array();
	
	if (!trim($_POST["msg"]))
	{
		$errors[] =_lang('Вы не ввели сообщение');
	}
	
	if (mb_strlen($_POST["msg"])>600)
	{
		$errors[] =_lang('Сообщение слишком длинное');
	}
	
	if (empty($user_info['login'])) //если юзер не зареген
	{
		if (!trim($_POST['name']))
		{
			$errors[] = _lang('Вы не ввели имя');
		}
		else
		{
			$result=$db->selectCell("SELECT COUNT(login) FROM ?_users WHERE login=?", trim($_POST["name"]));
			if ($result) $error[]=_lang('Такой пользователь уже зарегистрирован');
		}
	}
	
	if (!count($errors))
	{
		if ($mode=="edit")
		{
			$db->query("UPDATE ?_guest SET ?a WHERE msg_id=?", array('msg'=>$_POST['msg'], 'answer'=>$_POST['answer']), $_GET['var1']);
			refresh();
		}
		if ($mode=="add")
		{
			if ($user_info['user_id']>0)
			{
				$db->query("INSERT INTO ?_guest (user_id, msg, `date`, ip) VALUES (?, ?, NOW(), INET_ATON('".$_SERVER['REMOTE_ADDR']."'))", $user_info['user_id'], trim($_POST['msg']));
			}
			else
			{
				$db->query("INSERT INTO ?_guest (name, email, msg, `date`, ip) VALUES (?, ?, ?, NOW(), INET_ATON('".$_SERVER['REMOTE_ADDR']."'))", trim($_POST['name']), trim($_POST['email']), trim($_POST['msg']));
			}
			if ($config['guestbook_email_notify'] && $config['admin_mail'])
			{
				$mail = new htmlMimeMail();
				$mail->setText((($user_info['login'])?$user_info['login']:$_POST['name'])."(".(($user_info['email'])?$user_info['email']:$_POST['email']).") оставил сообщение в гостевой книге:\r\n".$_POST['msg']."\r\nhttp://".$_SERVER["SERVER_NAME"].url());
				$mail->setFrom('Робот гостевой <guestbook@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"].">"));
				$mail->setReturnPath('guestbook@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"]));
				$mail->setSubject('Новое сообщение в гостевой книге '.$_SERVER["SERVER_NAME"]);
				$mail->send(array($config['admin_mail']));
			}
			refresh();
		}
	}
	
}

$mod_template="edit_post.tpl"; 

if ($mode=="edit")
{
	$titlepage=_lang('Гостевая книга. Редактирование сообдения');
	$smarty->assign('content_name', titlepage);


	$post_data=$db->selectRow("SELECT msg_id, g.email, login, name, msg, answer  FROM ?_guest g LEFT JOIN ?_users u ON g.user_id=u.user_id WHERE msg_id=?", $_GET['var1']);
	$smarty->assign('post_data', $post_data);
}

if ($mode=="delete")
{
	$db->query("DELETE FROM ?_guest WHERE msg_id=?", $_GET['var1']);
	refresh();
}

$smarty->assign('errors', $errors);	  

?>
