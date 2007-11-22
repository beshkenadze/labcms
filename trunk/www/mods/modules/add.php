<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira 
 */
 if (access('add'))
{
	$mod_template='mod_show.tpl';
	$module = getModules();
	$smarty->assign("group_name","Имя группы");
	$smarty->assign("modules",$module);
}
?>
