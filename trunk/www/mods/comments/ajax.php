<?php
/*
 * Created on blog 05.04.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */

 $smarty->assign("mode",$mode);
 if($mode == "add") {
	if ($_SERVER['REQUEST_METHOD']=="POST" && access("add") && isset($_POST['msg']))
	{
		if ($_POST['name']) {sleep(20); exit();} //если постит робот, то посылаем его нафиг
		$_POST['name']=$_POST[$config['catcher']];
		unset($_POST[$config['catcher']]);

		$error=array();
		if (empty($_POST['msg']))
		{
			$error[]="Введите комментарий";
		}
		if(strlen($_POST['msg']) < 1) {
			$error[]="Слишком короткий комментарий";
		}
		if (empty($_POST['name']))
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
							'msg'=>$_POST['msg']);
			if ($user_info['user_id']>0)
			{
				$query['user_id']=$user_info['user_id'];
			}
			else
			{
				$query['email']=$_POST['email'];
				$query['name']=$_POST['name'];
			}
			$id_insert = $db->query("INSERT INTO ?_comments SET ?a, putdate=NOW(), ip=INET_ATON(?)", $query, $_SERVER['REMOTE_ADDR']);

		}
		$smarty->assign('errors', $error);
	}

	 //////////////////////
	 //	$core['comment']['module_id'] - id текущего компонента
	 //	$core['comment']['item_id'] - id айтема раздела
	 /////////////////////
	if ($core['comment']['item_id'])
	{
		$mod_template="show.tpl";
		//$total_comments=$db->selectCell("SELECT count(comment_id) FROM ?_comments WHERE module_id=? AND item_id=?", $module_id, $item_id);
		//$numCom =$total_comments;
		if($id_insert > 0) {
			$result=$db->select("SELECT u.user_id, login, u.email as u_email, name, c.email as c_email, putdate, msg, comment_id, INET_NTOA(ip) as ip FROM ?_comments c LEFT JOIN ?_users u ON c.user_id=u.user_id WHERE module_id=? AND item_id=? AND comment_id=? ORDER BY putdate DESC", $core['comment']['module_id'], $core['comment']['item_id'],$id_insert);
		}else{
			$result=$db->select("SELECT u.user_id, login, u.email as u_email, name, c.email as c_email, putdate, msg, comment_id, INET_NTOA(ip) as ip FROM ?_comments c LEFT JOIN ?_users u ON c.user_id=u.user_id WHERE module_id=? AND item_id=? ORDER BY putdate DESC", $core['comment']['module_id'], $core['comment']['item_id']);
		}
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
				$smarty->append('comments',array('name'=>$c_name, 'email'=>$c_email, 'putdate'=>$comms['putdate'], 'msg'=>$c_msg, 'id'=>$comms['comment_id'], 'ip'=>$comms['ip'], 'access_edit'=>$access_edit, 'access_delete'=>$access_delete));
			}
		}
		if(!count($error)){
			echo $con = $smarty->fetch("comments/".$mod_template);
		}else{
			echo $con = $smarty->fetch("comments/error_ajax.tpl");
		}
	//	echo iconv("windows-1251","utf-8",$con);
		exit;
	}

 }elseif($mode == "test") {
 	print_r($_POST);
 }
?>
