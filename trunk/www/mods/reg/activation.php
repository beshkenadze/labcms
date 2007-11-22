<?
$count = $db->selectCell("SELECT count(*) FROM ?_users l WHERE login like ? AND actkey like ? LIMIT 1",$_GET["var1"],$_GET["var2"]);
if($count){
	if($db->selectCell("SELECT status FROM ?_users l WHERE login like ? AND actkey like ? LIMIT 1",$_GET["var1"],$_GET["var2"]) == 1){
		refresh("Аккаунт уже был активирован, сейчас вы перейдете на главную страницу.","/",3);
	}
	$db->query("UPDATE ?_users SET status = 1 WHERE `login` like ? LIMIT 1 ;",$_GET["var1"]);
}
refresh("Спасибо за активацию, сейчас вы перейдете на главную страницу.","/",3);
?>
