<?php
 if($_GET["action"] == "page") {
  $page=intval($_GET['var1']);
 }elseif($_GET['var1']=="entry"){
  $blog_id=intval($_GET['var2']);
 }
  //Блок определения including module part (imp)
  switch (true)
  {
   case($_GET['action']=='add' && access("add")):
   $mode="add";
   include dirname(__FILE__)."/edit_blog.php";
   break;
   case($_GET['action']=='feed'):
   include dirname(__FILE__)."/feed.php";
   break;
   case($_GET['action']=='edit' && access("edit")):
   $mode="edit";
   include dirname(__FILE__)."/edit_blog.php";
   break;
   case($_GET['action']=='delete' && access("delete")):
   $mode="delete";
   include dirname(__FILE__)."/edit_blog.php";
   break;
   default:
   include dirname(__FILE__)."/blog.php";
  }
  $smarty->assign("base_url",$base_url);
?>
