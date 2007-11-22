<?
 $mod_template="art_list.tpl";

  $smarty->assign('art_list',$art_list);
  $smarty->assign('access_add', access("add"));
  $smarty->assign('access_edit', access("edit"));
  $smarty->assign('access_delete', access("delete"));
?>