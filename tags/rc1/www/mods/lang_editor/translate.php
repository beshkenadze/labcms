<?
	$mod_template="translate.tpl";
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		if (access('msg_edit'))
		{
			foreach($_POST['translate_text'] as $key=>$var)
			{
				if ($var)
				{
					$db->query("INSERT INTO ?_translate (text_id, lang_id, `text`) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE `text`=?", $key, $_GET['var1'], $var, $var);
				}
			}
		}
		
		if (access('msg_delete'))
		{
			if (count($_POST['delete_string']))
			{
				$db->query("DELETE FROM ?_translate_keys WHERE text_id IN (?a)", array_keys($_POST['delete_string']));
				$db->query("DELETE FROM ?_translate WHERE text_id NOT IN (SELECT text_id FROM ?_translate_keys)");
			}
		}
	}

	$smarty->assign('current_lang', $db->selectCell("SELECT lang_name FROM ?_langs WHERE lang_id=?", $_GET['var1']));

if ($mode=="edit")
{
	$smarty->assign('text_data', $db->select("SELECT tk.text_id, text_key, `text`, text_descr 
					    FROM  ?_translate_keys tk 
						LEFT JOIN (SELECT text_id, text 
						FROM ?_translate 
						WHERE lang_id=?) as t ON tk.text_id=t.text_id", $_GET['var1']));
}	

	
?>