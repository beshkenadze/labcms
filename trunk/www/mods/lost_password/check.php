<?php

$login = $_POST["user"][$config["catcher"]];
$email = $_POST["email"][$config["catcher"]];
if($login){
    $lost_info = $db->select("SELECT * FROM ?_users WHERE login like ?",$login);
}elseif($email){
    $lost_info = $db->select("SELECT * FROM ?_users WHERE email like ?",$email);
}else{
    refresh("Не заполнено поле");
}
if(empty($lost_info)) refresh("Пользователь не найден.");
		$mail = new PHPMailer();
//		$mail->IsSMTP();                                   // send via SMTP
//		$mail->Host     = "mail.infobox.ru"; // SMTP servers
//		$mail->SMTPAuth = true;     // turn on SMTP authentication
//		$mail->Username = "robot@msilab.net";  // SMTP username
//		$mail->Password = "2007robot"; // SMTP password
		$mail->Mailer="sendmail";
		$mail->CharSet="utf-8";
foreach($lost_info as $item){
    $new_pass=genKey(10);
    $actkey=genKey(6);
    $retrive[] = array(
    'login'=>$item["login"],
    'email'=>$item["email"],
    'new_pass'=>$new_pass,
    'key'=>$actkey
    );
    $db->query("UPDATE ?_users SET ?a WHERE `login` like ? LIMIT 1 ;",array('new_pass'=>md5($new_pass),'actkey'=>$actkey),$item["login"]);
    $mail->AddAddress($item["email"],$item["realname"]); 
}
$smarty->assign("retrive",$retrive);
$message = $smarty->fetch("lost_password/message.tpl");
$txt_message = $smarty->fetch("lost_password/txt_message.tpl");
$mail->Subject = "Восстановление пароля для сайт http://".$_SERVER["HTTP_HOST"];
$mail->Body     =  $message;
$mail->AltBody  =  $txt_message;
if(!$mail->Send())
{
  refresh("Ошибка работы почтового робота","/",2);
}else{
  refresh("Инструкции отправлены на email указанный в профиле","/",2);
}
exit;
?>