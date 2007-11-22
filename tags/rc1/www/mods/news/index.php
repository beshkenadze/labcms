<?php
if($_GET["action"] == "page") {
  $page=intval($_GET['var1']);
 }else{
  $news_id=intval($_GET['var1']);	
 }
  switch (true)
  {
   case($core['data_type']=='xml'):
	   include dirname(__FILE__)."/rss.php";
   break; 
   case($_GET['action']=='add' && access("add")):
	   $mode="add";
	   include dirname(__FILE__)."/edit_news.php";
   break;
   case($_GET['action']=='edit' && access("edit")):
	   $mode="edit";
	   include dirname(__FILE__)."/edit_news.php";
   break;
   case($_GET['action']=='delete' && access("delete")):
	   $mode="delete";
	   include dirname(__FILE__)."/edit_news.php";
   break;
   default: 
	   include dirname(__FILE__)."/news.php";
  } 
 $smarty->assign('component_data', $smarty->fetch($core['incs']['module'].$mod_template));
?>
