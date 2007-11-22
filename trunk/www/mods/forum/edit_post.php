<?
 $mod_template="edit_post.tpl";

 if ($_SERVER["REQUEST_METHOD"]=='POST')
 {
  if ($_POST['name']) {sleep(20); exit();} //если постит робот, то посылаем его нафиг
  $_POST['name']=$_POST[$config['catcher']];
  unset($_POST[$config['catcher']]);

	 $error="";

	  // Проверяем правильность ввода информации в поля формы
	  if (empty($_POST["msg"])) 
	  {
	    $error[] ="Вы не ввели сообщение";
	  }
	  if (empty($_POST["name"]) && empty($user_info['login'])) 
	  {
	    $error[] ="Вы не ввели имя";
	  }
	  elseif(empty($user_info['login']))
	  {
	   $result=$db->selectCell("SELECT COUNT(login) FROM ?_users WHERE login=?", $_POST["name"]);
	   if ($result) $error[]="Пользователь с таким именем уже зарегистрирован!";
	  }
	  
	  
	  if (isset($_POST['subj']) && $_POST['subj']=="")
          {
           $error[] ="Вы не ввели тему";
          }
	  if (!is_array($error))
	  {
		  // Обрабатываем HTML-тэги и скрипты в сообщении и информации
		  // об авторе, ограничиваем объём сообщения
		  $subj = substr(trim($_POST["subj"]),0,100);
		  $name = ($_POST['name']) ? substr(trim($_POST["name"]),0,32) : $user_info['login'];
		  $email = ($user_info['email']) ? $user_info['email'] : substr(trim($_POST["email"]),0,32);
		  $msg = substr(trim($_POST["msg"]),0,1024*15);

             //если режим редактирования и есть доступ для редактирования
            if ($mode=="edit")
            {
              $db->query("UPDATE ?_forum_posts SET msg=? WHERE post_id=?", $msg, $post_id);
		if ($subj) 
             {
              $db->query("UPDATE ?_forum_themes SET subject=? {, forum_id=?} WHERE theme_id=?", $subj, (access('edit')?$_POST['move_to_forum']:DBSIMPLE_SKIP),$forum_info['theme_id']);
			if($_POST['move_to_forum'])
			{
				$db->query("UPDATE ?_forum_forums ff SET total_posts=(SELECT SUM(total_posts) FROM ?_forum_themes ft WHERE ff.forum_id=ft.forum_id), total_themes=(SELECT COUNT(theme_id) FROM ?_forum_themes ft WHERE ff.forum_id=ft.forum_id), last_post=(SELECT last_post FROM ?_forum_themes ft WHERE ff.forum_id=ft.forum_id ORDER BY last_post DESC LIMIT 1), last_user=(SELECT last_user FROM ?_forum_themes ft WHERE ff.forum_id=ft.forum_id ORDER BY last_post DESC LIMIT 1)");
			}
             }
			 refresh('ok', $_SERVER['PHP_SELF']."-theme.".$forum_info['theme_id']."/999".$config['ext']."#last");
            }
            //если
            if ($mode=="new")
            {
			 $query=array(	'forum_id'=>$forum_info['forum_id'],
							'subject'=>$subj,
							'author'=>$name,
							'total_posts'=>1,
							'last_user'=>$name);
             $theme_id=$db->query("INSERT INTO ?_forum_themes SET ?a, last_post=NOW()", $query);
			 $query=array(	'theme_id'=>$theme_id,
							'user_name'=>$name,
							'msg'=>$msg,
							'email'=>$email);
             $db->query("INSERT INTO ?_forum_posts SET ?a, putdate=NOW(), ip=INET_ATON(?)", $query, $_SERVER['REMOTE_ADDR']);
             $db->query("UPDATE ?_forum_forums SET  total_posts=total_posts+1, total_themes=total_themes+1, last_post=NOW(),  last_user=? WHERE forum_id=?", $name, $forum_info['forum_id']);
			if ($config['forum_email_notify'] && $config['admin_mail'])
			{
				$mail = new htmlMimeMail();
				$mail->setText($name."(".$email.") создал новую тему: $subj\r\n".$msg."\r\nhttp://".$_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']."-theme.".$theme_id."/999".$config['ext']."#last");
				$mail->setFrom('Робот форума <forum@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"].">"));
				$mail->setReturnPath('forum@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"]));
				$mail->setSubject('Новая тема в форуме '.$_SERVER["SERVER_NAME"]);
				$mail->send(array($config['admin_mail']));
			}
			 refresh('ok', $_SERVER['PHP_SELF']."-theme.$theme_id/999".$config['ext']."#last");
            }
            if ($mode=="reply")
            {
			 $query=array(	'theme_id'=>$forum_info['theme_id'],
							'user_name'=>$name,
							'msg'=>$msg,
							'email'=>$email);
             $db->query("INSERT INTO ?_forum_posts SET ?a, putdate=NOW(), ip=INET_ATON(?)", $query, $_SERVER['REMOTE_ADDR']);
             $db->query("UPDATE ?_forum_themes SET  total_posts=total_posts+1, last_post=NOW(),  last_user=? WHERE theme_id=?", $name, $forum_info['theme_id']);
            $db->query("UPDATE ?_forum_forums SET  total_posts=total_posts+1, last_post=NOW(),  last_user=? WHERE forum_id=?", $name,$forum_info['forum_id']);
			if ($config['forum_email_notify'] && $config['admin_mail'])
			{
				$mail = new htmlMimeMail();
				$mail->setText($name."(".$email.") ответил в теме: ".$forum_info['subject']."\r\n".$msg."\r\nhttp://".$_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']."-theme.".$forum_info['theme_id']."/999".$config['ext']."#last");
				$mail->setFrom('Робот форума <forum@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"].">"));
				$mail->setReturnPath('forum@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"]));
				$mail->setSubject('Новый ответ форуме '.$_SERVER["SERVER_NAME"]);
				$mail->send(array($config['admin_mail']));
			}
             refresh('ok', $_SERVER['PHP_SELF']."-theme.".$forum_info['theme_id']."/999".$config['ext']."#last");
            }


            }
//если есть ошибки
            else
            {
             $smarty->assign("errors", $error);
            }
 }
 
 if ($mode=="delete")
 {
  ///если сообщение является последним в разделе форума
  $last_in_forum=$db->selectCell("SELECT fp.post_id FROM ?_forum_posts fp JOIN ?_forum_themes ft ON fp.theme_id=ft.theme_id WHERE ft.forum_id=? ORDER BY putdate DESC LIMIT 1", $forum_info['forum_id']);
  //если сообщение последнее в форуме, значит и в теме оно последнее
  if ($last_in_forum!=$forum_info['post_id']) 
  {
   $last_in_theme=$db->selectCell("SELECT post_id FROM ?_forum_posts WHERE theme_id=? ORDER BY putdate DESC LIMIT 1", $forum_info['theme_id']);
  }

  $db->query("DELETE FROM ?_forum_posts WHERE post_id=?", $post_id);
  
  if ($last_in_forum==$forum_info['post_id'])
  {
   $query=$db->selectRow("SELECT fp.user_name as last_user, fp.putdate as last_post FROM ?_forum_posts fp JOIN ?_forum_themes ft ON fp.theme_id=ft.theme_id WHERE ft.forum_id=? ORDER BY putdate DESC LIMIT 1", $forum_info['forum_id']);
   $db->query("UPDATE ?_forum_themes SET ?a, total_posts=total_posts-1 WHERE theme_id=?", $query, $forum_info['theme_id']);
   $db->query("UPDATE ?_forum_forums SET ?a, total_posts=total_posts-1 WHERE forum_id=?", $query, $forum_info['forum_id']);
  }
  elseif ($last_in_theme==$forum_info['post_id'])
  {
   $query=$db->selectRow("SELECT user_name as last_user, putdate as last_post FROM ?_forum_posts WHERE theme_id=? ORDER BY putdate DESC LIMIT 1", $forum_info['theme_id']);
   $db->query("UPDATE ?_forum_themes SET ?a, total_posts=total_posts-1 WHERE theme_id=?", $query, $forum_info['theme_id']);
   $db->query("UPDATE ?_forum_forums SET total_posts=total_posts-1 WHERE forum_id=?", $forum_info['forum_id']);
  }
  else
  {
   $db->query("UPDATE ?_forum_themes SET total_posts=total_posts-1 WHERE theme_id=?", $forum_info['theme_id']);
   $db->query("UPDATE ?_forum_forums SET total_posts=total_posts-1 WHERE forum_id=?", $forum_info['forum_id']);  
  }
  refresh('ok', $_SERVER['PHP_SELF']."-theme.".$forum_info['theme_id']."/999".$config['ext']."#last");
 }
 
 //удаление темы
  if ($mode=="delete_theme")
 {
  ///если сообщение является последним в разделе форума
  $last_in_forum=$db->selectCell("SELECT theme_id FROM ?_forum_themes WHERE forum_id=? ORDER BY last_post DESC LIMIT 1", $forum_info['forum_id']);
  //узнаем количество постов в теме
  $total_posts=$db->selectCell("SELECT count(post_id) FROM ?_forum_posts WHERE theme_id=?", $forum_info['theme_id']);

  $db->query("DELETE FROM ?_forum_posts WHERE theme_id=?", $theme_id);
  $db->query("DELETE FROM ?_forum_themes WHERE theme_id=?", $theme_id);
  
  if ($last_in_forum==$theme_id)
  {
   $query=$db->selectRow("SELECT last_user, last_post FROM ?_forum_themes WHERE forum_id=? ORDER BY last_post DESC LIMIT 1", $forum_info['forum_id']); 
   if (!count($query)) $query=array('last_user'=>"", 'last_post'=>"");
   $db->query("UPDATE ?_forum_forums SET ?a, total_posts=total_posts-?d, total_themes=total_themes-1 WHERE forum_id=?", $query, $total_posts, $forum_info['forum_id']);
  }
  refresh('ok', $_SERVER['PHP_SELF'].".".$forum_info['forum_id'].$config['ext']);
 }
 
 //ответ на сообщение
 if ($mode=="reply")
 {
	if ($_SERVER['REQUEST_METHOD']=="GET")	$smarty->assign("msg", '[q="'.$forum_info['user_name'].'"]'.$forum_info['msg']."[/q]");
	$smarty->assign("reply_info", show_post($forum_info));
 }

 //редактирование собщения
 if ($mode=="edit")
 {
  //проверяем, является ли это сообщение первым
  $first_post=$db->selectCell("SELECT post_id FROM ?_forum_posts WHERE theme_id=? ORDER BY putdate LIMIT 1", $forum_info['theme_id']);
  if ($first_post==$forum_info['post_id']) $smarty->assign('edit_subj',1);
  if ($_SERVER["REQUEST_METHOD"]!='POST') $smarty->assign($forum_info);
 }

 //если передан forum_id, значит добавляем новую тему
 if ($mode=="new")
 {
  $smarty->assign('edit_subj',1);
 }
  $smarty->assign('mode', $mode);
?>