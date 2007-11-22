<?
 $mod_template="show.tpl";
 $smarty->assign($page_info);
 $titlepage=$page_info['page_title'];
  $smarty->assign('access_edit', access("edit"));
  $smarty->assign('access_delete', access("delete"));
?>
