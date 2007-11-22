<?
if (access('read'))
{
	function getAllPermis(){
		global $db;
		$result=$db->selectRow("SHOW COLUMNS FROM ?_access LIKE 'permis'");
  		preg_match_all("|'(.*?)'|", $result['Type'], $acc);
  		return $acc[1];
	}
	if($_REQUEST["var1"] == "group"){
		$mod_template='mod_group_show.tpl';
		if($_REQUEST["var2"]>0){
			$group_id = is_numeric($_REQUEST["var2"]) ? $_REQUEST["var2"] : refresh("Error", $_SERVER["HTTP_REFERER"]);
			$group = $db->select("SELECT * FROM ?_groups WHERE `group_id` = ? LIMIT 1;", $group_id);// Вытаскиваем о его группе
			$modules = getModules();

			foreach($modules as $m) {
				//print_r($m);
				$mod_access = getAcces($m["module_id"],$group_id);
				if($mod_access) {
					$perm=array();
					$new_access = explode(",",$mod_access[0]["permis"]);
					foreach($new_access as $item_access){
						$perm[$item_access] = true;
					}
					$m["permis"] = $perm;
				}
				$newmod[]=$m;
			}
			//print_r($newmod);
			$smarty->assign("allpermis",getAllPermis());
			$smarty->assign("modules",$newmod);
			$smarty->assign("group",$group[0]);
		}elseif($_REQUEST["var2"] == "0"){
			$modules = getModules();

			foreach($modules as $m) {

				$mod_access = getAcces($m["module_id"],$group_id);
				if($mod_access) {
					$perm=array();
					$new_access = explode(",",$mod_access[0]["permis"]);
					foreach($new_access as $item_access){
						$perm[$item_access] = true;
					}
					$m["permis"] = $perm;
				}
				$newmod[]=$m;
			}
			//print_r($newmod);
			$smarty->assign("allpermis",getAllPermis());
			$smarty->assign("modules",$newmod);
			$smarty->assign("group",array("group_name"=>"Не зарегистрированные"));
		}else{
			$modules = getModules();

			foreach($modules as $m) {

				$mod_access = getAcces($m["module_id"]);
				if($mod_access) {
					$perm=array();
					$new_access = explode(",",$mod_access[0]["permis"]);
					foreach($new_access as $item_access){
						$perm[$item_access] = true;
					}
					$m["permis"] = $perm;
				}
				$newmod[]=$m;
			}
			//print_r($newmod);
			$smarty->assign("allpermis",getAllPermis());
			$smarty->assign("modules",$newmod);
			$smarty->assign("group",array("group_name"=>"Имя группы"));
		}
	}else{
		$mod_template='mod_show.tpl';
		$all_groups = getUserGroups();// Вытаскиваем все группы
		if($_REQUEST["var1"]>0){
			$user_id = is_numeric($_REQUEST["var1"]) ? $_REQUEST["var1"] : refresh("Error: Не верный ID пользователя", "/users");
			$user = $db->select("SELECT * FROM ?_users WHERE `user_id` = ? LIMIT 1;", $user_id);// Вытаскиваем данные о юзере
			$user_group = $db->select("SELECT * FROM ?_groups WHERE `group_id` = ? LIMIT 1;", $user[0]["group_id"]);// Вытаскиваем о его группе
			if (!access('edit')) {
				$user[0]["pass"]="пароль скрыт";
			}
			$smarty->assign("user",$user[0]);
			$smarty->assign("user_group",$user_group[0]);
		}
		$smarty->assign("access_edit",access('edit'));
		$smarty->assign("user_info",$user_info);
		$smarty->assign("all_groups",$all_groups);
		
	}
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}

?>
