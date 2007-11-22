<?php
if($_GET["action"] == "page") {
  $page=intval($_GET['var1']);
 }elseif($_GET['var1']=="entry"){
  $folio_id=intval($_GET['var2']);	
 }
 
  //Блок определения including module part (imp)
  switch (true)
  {
   case($_GET['action']=='add' && access("add")):
   $mode="add";
   include dirname(__FILE__)."/edit_folio.php";
   break;
   case($_GET['action']=='edit' && access("edit")):
   $mode="edit";
   include dirname(__FILE__)."/edit_folio.php";
   break;
   case($_GET['action']=='delete' && access("delete")):
   $mode="delete";
   include dirname(__FILE__)."/edit_folio.php";
   break;
   default: 
   include dirname(__FILE__)."/folio.php";
  } 
 $smarty->assign('component_data', $smarty->fetch($core['incs']['module'].$mod_template));
?>
