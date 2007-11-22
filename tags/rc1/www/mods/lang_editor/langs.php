<?
	$mod_template="langs.tpl";
	$smarty->assign('langs', $db->select("SELECT lang_id, lang_name FROM ?_langs"));
?>