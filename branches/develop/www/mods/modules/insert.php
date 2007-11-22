<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira 
 */
if (access('add'))
{
	$group_id = $db->query("INSERT INTO ?_group_inc VALUES ('', ?)", $_REQUEST["group_name"]);
	foreach($_REQUEST['mod'] as $mod_id) {
    	is_numeric($mod_id) ? '' : exit($mod_id) ; // Проверяем данные
		$query=array(	'group_id'=>$group_id,
						'module_id'=>$mod_id);
    	$db->query("INSERT INTO ?_includes SET ?a", $query);// Добавляем 
    }
    
    refresh('ok', $_SERVER["PHP_SELF"]."-show.".$group_id.$config['ext']);
}

?>
