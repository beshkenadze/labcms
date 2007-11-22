<?php
/*
 * Created on flex 20.05.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
function getAllSections() {
	global $db;
    return $db->select("SELECT * FROM ?_todo WHERE task = ?",0);
}
function getTaskList($id) {
	global $db;
	$id = is_numeric($id) ? $id : 1;
    return $db->select("SELECT * FROM ?_todo WHERE parent_id = ? and task = ?",$id,1);
}

function getPartInfo($id) {
	global $db;
	$id = is_numeric($id) ? $id : 1;
    return $db->select("SELECT * FROM ?_todo WHERE todo_id = ? and task = ?",$id,0);
}
function getTaskInfo($id) {
	global $db;
	$id = is_numeric($id) ? $id : 1;
    return $db->select("SELECT * FROM ?_todo WHERE todo_id = ? and task = ?",$id,1);
}
?>
