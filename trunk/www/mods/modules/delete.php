<?
if (access('delete'))
{
	$group_id = is_numeric($_REQUEST["var2"]) ? $_REQUEST["var2"] : refresh("Error", $_SERVER["HTTP_REFERER"]);
	$db->query("DELETE FROM ?_includes WHERE `group_id` = ? LIMIT 1", $group_id);
    $db->query("DELETE FROM ?_group_inc WHERE `group_id` = ? LIMIT 1", $group_id);
    refresh('ok');
}
?>