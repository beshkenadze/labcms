<?
if (access('read'))
{
	$mod_template="mod_list.tpl";
	$module = getModules();
	$result=$db->select("SELECT * FROM ?_group_inc ORDER BY NAME"); // Все группы
	foreach($result as $groups){
	    $group[] = $groups; 
	}
	$smarty->assign("modules",$module);
	$smarty->assign("groups",$group);
}
?>