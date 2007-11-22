<?
function smarty_block_t($params, $text_key, &$smarty)
{
	global $db, $core;
	if ($text_key)
	{
		if (!$core['translate'][$core['lang_id']]) $core['translate'][$core['lang_id']]=prepare_lang();
		if (!$core['translate'][$core['lang_id']][$text_key])
		{
			$db->query("INSERT INTO ?_translate_keys (text_key, text_descr) VALUES(?, ?)", $text_key, $_SERVER['REQUEST_URI']);
			echo $text_key;
		}
		else
		{
			echo $core['translate'][$core['lang_id']][$text_key];
		}
	}
}
?>