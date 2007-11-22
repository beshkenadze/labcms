<?
$mod_template="";
if ($_SERVER['REQUEST_METHOD']=="POST" && access("edit") && $_POST['skin_select'])
{
	if (!preg_match('/\//', $_POST['skin_select']) && file_exists($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$_POST['skin_select']))
	{
		$_SESSION['skin']=$_POST['skin_select'];
		refresh('Установлен скин: '.$_POST['skin_select'], $_SERVER['REQUEST_URI']);
	}
}
elseif(access("read"))
{
$mod_template="default.tpl";
	$skins=glob($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH."*", GLOB_ONLYDIR);
	foreach ($skins as $skin)
	{
		$smarty->append('skin_select', basename($skin));
	}
	$smarty->assign('access_edit', access('edit'));
}
?>