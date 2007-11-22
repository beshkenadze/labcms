<?
if (access('read'))
{
	if($_REQUEST["var1"]=="module"){
		$mod_name = $_REQUEST["var2"]."/";
		$result=$db->selectRow("SELECT name as mod_name, component, static, search FROM ?_modules WHERE `module` like ? LIMIT 1", $mod_name);
		$mod_template='mod_install.tpl';
		$smarty->assign($result);
	}else{
		$group_id = is_numeric($_REQUEST["var1"]) ? $_REQUEST["var1"] : refresh("Error", $_SERVER["HTTP_REFERER"]);
		$mod_template='mod_show.tpl';
		$result = $db->select("SELECT m.module_id,m.name module_name,gi.name group_name FROM ?_includes i, ?_group_inc gi, ?_modules m WHERE i.module_id = m.module_id AND i.group_id = gi.group_id AND i.group_id = ? ORDER BY m.name;", $group_id);// Вытаскиваем данные о модулях в данной группе
		$module = getModules();
		foreach($result as $groups){
		    $group[] = $groups;
		    $group_name = $groups["group_name"];
		    foreach($module as $name=>$mod) {
		  	    if($mod['module_id'] == $groups['module_id']) {
		  	    	$module[$name]['select']=1;
		  	    }
		    }
		}

		$smarty->assign("group_name",$group_name);
		$smarty->assign("groups",$group);
		$smarty->assign("modules",$module);
	}
}
?>
