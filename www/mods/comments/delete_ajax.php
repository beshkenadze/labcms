<?

is_numeric($_POST["comment_id"]) ? "" : exit("Неверный тип данных") ;
$comment_info=$db->selectRow("SELECT comment_id, module_id, item_id, c.user_id, name,  msg, login FROM ?_comments c LEFT JOIN ?_users u ON c.user_id=u.user_id WHERE comment_id=?", $_POST["comment_id"]);

if ((access("delete") || (access("msg_delete") && $user_info['user_id']==$comment_info['user_id'])))
{
		$db->query("DELETE FROM ?_comments WHERE comment_id=? LIMIT 1", $_POST["comment_id"]);
		echo "Удалили";
}else{
	if(!access("delete")) echo "Нельзя удалять \n";
	if(!access("msg_delete")) echo "Нельзя удалять сообщение";
	
}
?>