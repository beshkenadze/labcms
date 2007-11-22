<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
 if (access('admin'))
{
		$module_id = is_numeric($_REQUEST["var2"]) ? $_REQUEST["var2"] : refresh("Bad number", $_SERVER["HTTP_REFERER"]);
		$query=array('disable'=>$_REQUEST["var1"] == "on" ? 1 : 0);
		$db->query("UPDATE ?_modules SET ?a WHERE `module_id` like ?;", $query, $module_id) ? refresh("OK", $_SERVER["HTTP_REFERER"]) : refresh("Error SQL Update", $_SERVER["HTTP_REFERER"],10) ;

}
?>
