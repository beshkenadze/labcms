<?
if (access("read"))
{
	$mod_template="mod_show.tpl";

	$smarty->assign("user",$_SESSION["user_post_data"]);
	$smarty->assign("catcher",$config["catcher"]);
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}
?>
