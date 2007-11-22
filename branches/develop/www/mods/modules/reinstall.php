<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
 if (access('admin'))
{
	if($_REQUEST["mod_name"]){

		$mod = $_REQUEST["var1"]."/";
		$info = getModuleInfo($_GET["var1"]);
		$sqlFiles = getModulesSql($_GET["var1"]);
		$query=array(	'name'=>$_REQUEST["mod_name"],
						'component'=>($_REQUEST["component"] ? 1 : 0),
						'static'=>($_REQUEST["static"] ? 1 : 0),
						'search'=>($_REQUEST["search"] ? 1 : 0));
		$db->query("UPDATE ?_modules SET ?a WHERE `module` like ?;", $query, $mod);
		if($sqlFiles){
			foreach($sqlFiles as $sqlf) {
				parse_mysql_dump($sqlf);
			}
		}
	refresh();
	}else{
	    $info = getModuleInfo($_GET["var1"]);
		$mod_template='mod_reinstall.tpl';
		$smarty->assign("path",$_REQUEST["var1"]);
		$smarty->assign("info",$info);
	}
}
?>
