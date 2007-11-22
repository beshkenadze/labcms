<?
$a_info = $db->selectRow("SELECT * FROM ?_users  WHERE login like ? AND actkey like ? LIMIT 1",$_GET["var1"],$_GET["var2"]);

if($a_info){
    $db->query("UPDATE ?_users SET ?a WHERE `login` like ? LIMIT 1 ;",array('actkey'=>'','pass'=>$a_info["new_pass"],'new_pass'=>''),$_GET["var1"]);
}
refresh("Пароль изменен.","/",2);
?>
