<?
if ($mode=="delete")
{
	$db->query("DELETE FROM ?_langs WHERE lang_id=?", $_GET['var1']);
	$db->query("DELETE FROM ?_translate WHERE lang_id=?", $_GET['var1']);
	reset_session_set();
	refresh();
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
	$errors=array();
	if (!$_POST['lang_name']) $errors[]=_lang('Название языка не может быть путым!');
	if (!$_POST['key']) $errors[]=_lang('Обозначение языка не может быть путым!');;
	
	if (!count($errors))
	{
		if ($mode=="add")
		{
			$db->query("INSERT INTO ?_langs (lang_name, `key`) VALUES(?, ?)", $_POST['lang_name'], $_POST['key']);
		}
		if ($mode=="edit")
		{
			$db->query("UPDATE ?_langs SET lang_name=?, `key`=? WHERE lang_id=?", $_POST['lang_name'], $_POST['key'], $_GET['var1']);
		}
		reset_session_set();
		refresh();
	}
}

$mod_template="edit_lang.tpl";

if ($mode=="edit")
{
	$smarty->assign("lang_data", $db->selectRow("SELECT lang_id, lang_name, `key` FROM ?_langs WHERE lang_id=?", $_GET['var1']));
}
?>