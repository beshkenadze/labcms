<?
if (access('delete') )
{
   //обнуляем данные текущих сессий
   reset_session_set();

    if($_GET["var1"] == "group") {
		$group_id = is_numeric($_REQUEST["var2"]) ? $_REQUEST["var2"] : refresh("Error", $_SERVER["HTTP_REFERER"]);	
		$group_id > 1 ? "" :  refresh('Группу СуперАдмин нельзя удалить'); ;
		$db->query("DELETE FROM ?_groups WHERE `group_id` = ?", $group_id);
		$db->query("DELETE FROM ?_access WHERE `group_id` = ?", $group_id);
    	refresh('OK');
    }else{
    	$user_id = is_numeric($_REQUEST["var1"]) ? $_REQUEST["var1"] : refresh("Error", $_SERVER["HTTP_REFERER"]);	
		$db->query("DELETE FROM ?_users WHERE `user_id` = ?", $user_id);
    	refresh('OK');
    }
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}
?>