<?php

 if($_GET["action"] == "page") {
  $page=intval($_GET['var1']);
 }elseif($_GET['var1']=="entry"){
  $blog_id=intval($_GET['var2']);
 }elseif(is_numeric($_GET['var1']) and !is_numeric($_GET['var2'])){
 	$todo_id = $_GET['var1'];
 }elseif(is_numeric($_GET['var1']) and is_numeric($_GET['var2'])){
 	$todo_id = $_GET['var1'];
 	$task_id = $_GET['var2'];
 }
  include dirname(__FILE__)."/functions.php";
  	
  switch (true)
  {
   case($_GET['action']=='add' && access("add")):
        include dirname(__FILE__)."/add.php";
   break;
   case($_GET['action']=='insert' && access("add")):
        include dirname(__FILE__)."/insert.php";
   break;
   case($_GET['action']=='edit' && access("edit")):
        include dirname(__FILE__)."/edit.php";
   break;
   case($_GET['action']=='delete' && access("delete")):
        include dirname(__FILE__)."/delete.php";
   break;
   default:
   include dirname(__FILE__)."/list.php";
  }
?>
