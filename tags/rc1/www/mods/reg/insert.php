<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
if (access('add'))
{
		 if ($_POST['name']) {sleep(20); exit();} //если постит робот, то посылаем его нафиг
		$_SESSION["user_post_data"] = $row;
		 $_POST["user"]['login']=$_POST["user"][$config['catcher']];
		unset($_POST["user"][$config['catcher']]);
		$row = $_POST["user"];
		if(empty($row["login"])){
			refresh("Поле логина пустое.", $_SERVER["HTTP_REFERER"]);
		}
		if(!checkEmail($row["email"])){
            refresh("Поле email неверное.", $_SERVER["HTTP_REFERER"]);
		}
		if($db->selectCell("SELECT count(*) FROM ?_users l WHERE login like ? LIMIT 1",$_POST["login"])){
			refresh("Логин занят.", $_SERVER["HTTP_REFERER"]);
		};
		if(empty($row["pass"]) OR empty($row["pass1"]) AND empty($row["pass"]) != empty($row["pass1"])) {
			refresh("Поля пароля не совпадает или пароль пустой, что не допустимо.", $_SERVER["HTTP_REFERER"]);
		}else{
			unset($row["pass1"]);
			$row["pass"] = md5($row["pass"]);
		}

		$row["register_date"] = date("Y-m-d H:i:s");
		$row["actkey"] = genKey(12);
		//print_r($row);
		$smarty->assign('reg',$row);
		$mess = $smarty->fetch("reg/activation_message.tpl");

		$mail = new htmlMimeMail();
		$mail->setText($mess);
		$mail->setFrom('Робот <robot@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"].">"));
		$mail->setReturnPath('robot@'.preg_replace('/^www/', '', $_SERVER["SERVER_NAME"]));
		$mail->setSubject('Регистрация на '.$_SERVER["SERVER_NAME"]);
		$mail->send(array($row["email"]));
	    if($user_id = $db->query('INSERT INTO ?_users (?#) VALUES(?a)',array_keys($row),array_values($row))){
	    	refresh('Регистрация завершена. На указанный email придет потверждение.', "/",3);
	    }else{
	   	 $db->setErrorHandler('databaseErrorHandler');
	   	 exit;
	    }
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}
 exit;
?>
