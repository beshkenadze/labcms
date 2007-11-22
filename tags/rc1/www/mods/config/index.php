<?
$mod_template="config.tpl";
if ($_SERVER['REQUEST_METHOD']=='POST' && access("edit"))
{
   //обнуляем данные текущих сессий
   reset_session_set();

	$error="";
	$delay=0;
	foreach ($_POST as $key=>$val)
	$result=$db->query("UPDATE ?_config SET value=? WHERE name=?", $val, $key);
	if (!isset($result))
	{
		$error="Во время сохранения произошли ошибки";
		$delay=3;
	}
	refresh($error, $delay);
}

$conf=$db->select("SELECT name, value, `describe` FROM ?_config");
$smarty->assign('config_form', $conf);
?>