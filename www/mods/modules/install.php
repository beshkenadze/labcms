<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
 if (access('admin'))
{
	if($_REQUEST["mod_name"]){
		$info = getModuleInfo($_GET["var1"]);
	    $mod_access = "read";
		$sqlFiles = getModulesSql($_GET["var1"]);
		$query=array(	'module'=>$_REQUEST[var1]."/",
						'name'=>$_REQUEST["mod_name"],
						'component'=>($_REQUEST["component"] ? 1 : 0),
						'static'=>($_REQUEST["static"] ? 1 : 0),
						'search'=>($_REQUEST["search"] ? 1 : 0))
						;
		if($sqlFiles){
			foreach($sqlFiles as $sqlf) {
				parse_mysql_dump($sqlf);
			}
		}
	$module_id=$db->query("INSERT INTO ?_modules SET ?a", $query);
	refresh("OK");
	}else{
	    $info = getModuleInfo($_GET["var1"]);

		$mod_template='mod_install.tpl';
		$smarty->assign("path",$_REQUEST["var1"]);
		$smarty->assign("install",true);
		$smarty->assign("info",$info);
	}
}
?>
