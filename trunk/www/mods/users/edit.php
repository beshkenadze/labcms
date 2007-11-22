<?
if (access('edit'))
{
		if($_GET["var1"] == "group") {
			
			//$mod = ($_POST["module"]["Статьи"]);
			foreach($_POST["module"] as $mod) {
				$group_id = is_numeric($mod["group_id"]) ? $mod["group_id"] : refresh("Error", $_SERVER["HTTP_REFERER"]);
				$module_id = is_numeric($mod["module_id"]) ? $mod["module_id"] : refresh("Error", $_SERVER["HTTP_REFERER"]);
					(count($mod["permis"])) ? $permis_tmp=implode(",",array_keys($mod["permis"])) : $permis_tmp=null;
					$db->query("INSERT INTO ?_access (group_id, module_id, permis) VALUES(?, ?, ?)
  ON DUPLICATE KEY UPDATE permis=?",$group_id,$module_id,$permis_tmp, $permis_tmp);
			}
	
			foreach($_POST["group"] as $key=>$u) {
				$group[$key] = $u;
			}
			if($group_id > 0){
				$db->query("UPDATE ?_groups SET  ?a WHERE `group_id` = ? LIMIT 1 ;", $group, $group_id);// Обновим пользователя
			}
		    refresh('ok',$_SERVER["HTTP_REFERER"]);
		}else{
			$user_id = is_numeric($_REQUEST["var1"]) ? $_REQUEST["var1"] : refresh("Error", $_SERVER["HTTP_REFERER"]);	
			if ($_POST["user"]["pass"]==$_POST["user"]["pass1"] AND !empty($_POST["user"]["pass"]))
			{
				$_POST["user"]["pass"]=md5($_POST["user"]["pass"]);
				unset($_POST["user"]["pass1"]);
			}
			else
			{
				unset($_POST["user"]["pass"]);
				unset($_POST["user"]["pass1"]);
			}
			foreach($_POST["user"] as $key=>$u) {
				$user[$key] = $u;
			}
			$db->query("UPDATE ?_users SET  ?a WHERE `user_id` = ? LIMIT 1 ;", $user, $user_id);// Обновим пользователя

   //обнуляем данные текущих сессий
   reset_session_set();

		    refresh('ok', $_SERVER["HTTP_REFERER"]);
		}
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}
?>