<?php
/*
 * Created on flex 20.05.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */

if($todo_id and empty($task_id)) {
	$part_info = getPartInfo($todo_id);
	$smarty->assign("part_info", $part_info);
	$titlepage = "Раздел ".$part_info[0]["name"];

	$core['nav']['path'][]= "";
    $core['nav']['name'][]= $titlepage;
    $mod_template="task-list.tpl";

    $smarty->assign("task_list", getTaskList($todo_id));
}elseif($task_id) {
	$task_info  = getTaskInfo($task_id);
	$part_info = getPartInfo($todo_id);
	$titlepage = "Задача ".$task_info[0]["name"];
	
    
    $core['nav']['path'][]= $_SERVER["PHP_SELF"].".".$todo_id;
    $core['nav']['name'][]= "Раздел ".$part_info[0]["name"];
    
    $core['nav']['path'][]= "";
    $core['nav']['name'][]= $titlepage;
    $core['comment']['module_id']=$core['inc']['module_id'];
	$core['comment']['item_id']= $task_id; // идентификатор текущей новости
    $mod_template="task.tpl";
    $smarty->assign("part_info", $part_info);
    $smarty->assign("task", $task_info);
}else{
	$titlepage = "Список разделов";

    $mod_template="list.tpl";

}


$smarty->assign("sections", getAllSections());
$smarty->assign("access_add", access('add'));
$smarty->assign("access_edit", access('edit'));
$smarty->assign("access_delete", access('delete'));
?>
