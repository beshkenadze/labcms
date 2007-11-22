<?php
/*
 * Created on flex 20.05.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
if($_GET["var1"] == "part") {
    $mod_template="add-part.tpl";
    $titlepage = "Создать раздел";

}elseif($_GET["var1"] == "task" and is_numeric($_GET["var2"])){
    $mod_template="add-task.tpl";
    $titlepage = "Создать задачу";
}
$smarty->assign("sections", getAllSections());
$smarty->assign("users", getUsers());
$smarty->assign("groups", getUserGroups());
$core['nav']['path'][]= "";
$core['nav']['name'][]= $titlepage;
?>
