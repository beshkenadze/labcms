<?php
if($_POST["pass"]){
    if($_POST["pass"] != $_POST["pass1"]) {
        refresh("Пароли не совпадают",$_SERVER["HTTP_REFERER"],3);
    }else{
        $update["pass"] = md5($_POST["pass"]);
        $userdata["user_password"]=$update["pass"];
    }
}

if(preg_match("#\b[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b#i",$_POST["email"])){
    $update["email"] = $_POST["email"];
}


$update["website"] = strip_tags($_POST["website"]);
$update["icq"] = is_numeric($_POST["icq"]) ? $_POST["icq"] : "";
$update["realname"] = strip_tags($_POST["realname"]);


$userdata["user_email"]=$update["email"];
$userdata["user_icq"]=$update["icq"];
$userdata["user_website"]=$update["website"];

$db->query("UPDATE ?_users SET  ?a WHERE `user_id` = ? LIMIT 1 ;", $update, $user_info["user_id"]);// Обновим пользователя
//уничтожаем текущие сессии
reset_session_set();
refresh("OK","/profile");
?>