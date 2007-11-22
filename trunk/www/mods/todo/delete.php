<?php
/*
 * Created on flex 20.05.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
if(is_numeric($_GET["var2"])) {
	if($count=$db->selectCell("SELECT COUNT(todo_id) FROM ?_todo WHERE todo_id = ?;",$_GET["var2"])) {
		if($db->query("DELETE FROM ?_todo WHERE todo_id = ? LIMIT 1",$_GET["var2"])) {
			refresh("OK");
		}else{
			refresh("Error");
		}
	}
}
?>
