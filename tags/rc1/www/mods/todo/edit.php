<?php
/*
 * Created on flex 20.05.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
if($_GET["var1"] == "part" and !is_numeric($_GET["var2"])) {
    $mod_template="edit-part.tpl";
    $titlepage = "Создать раздел";

}elseif($_GET["var1"] == "task" and is_numeric($_GET["var2"])){
    $mod_template="edit-task.tpl";
    $titlepage = "Создать задачу";
    $task_info = getTaskInfo($_GET["var2"]);
    $smarty->assign("part", getPartInfo($task_info[0]["parent_id"]));
    $smarty->assign("task",$task_info[0]);
}elseif($_GET["var1"] == "part" and is_numeric($_GET["var2"])){
	$smarty->assign("part", getPartInfo($_GET["var2"]));
	$mod_template="edit-part.tpl";
}

 $smarty->assign("sections", getAllSections());
 $smarty->assign("users", getUsers());
$smarty->assign("groups", getUserGroups());
?>
