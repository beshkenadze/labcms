<?
if (access('edit'))
{
	if($_REQUEST["var1"] == "module"){
		$mod = $_REQUEST["var2"]."/";
		$query=array(	'name' => $_REQUEST["mod_name"],
						'component' => ($_REQUEST["component"] ? 1 : 0),
						'static'=>($_REQUEST["static"] ? 1 : 0),
						'search'=>($_REQUEST["search"] ? 1 : 0));
		$db->query("UPDATE ?_modules SET ?a WHERE `module` like ?;", $query, $mod);
		refresh('ok');
	}else{
		$name = $_REQUEST["group_name"];
		$group_id = is_numeric($_REQUEST["var1"]) ? $_REQUEST["var1"] : refresh("Error", $_SERVER["HTTP_REFERER"]);
		$db->query("DELETE FROM ?_includes WHERE `group_id` = ?", $group_id);// Чистим от модулей
	    $db->query("UPDATE ?_group_inc SET `name` = ? WHERE `group_id` = ?;", $name, $group_id);// Обновим модуль

	    foreach($_REQUEST['mod'] as $mod_id) {
	    	is_numeric($mod_id) ? '' : exit($mod_id) ; // Проверяем данные
			$query=array(	'group_id'=>$group_id,
							'module_id'=>$mod_id);
	    	$db->query("INSERT INTO ?_includes SET ?a", $query);// Добавляем
	    }
	    refresh('Все хорошо!',$_SERVER["HTTP_REFERER"]);
	}


}
?>