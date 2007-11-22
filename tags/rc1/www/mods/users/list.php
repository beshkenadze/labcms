<?
if (access("read"))
{
	$mod_template="mod_list.tpl";
	$users=$db->select("SELECT * FROM ?_users WHERE user_id > 0 ORDER BY login"); // Все группы
	$smarty->assign("users",$users);
	$smarty->assign("groups",getUserGroups());
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}
?>
