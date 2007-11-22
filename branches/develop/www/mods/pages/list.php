<?
 $mod_template="list.tpl";
  $list=$db->select("SELECT page_id, page_title, path FROM ?_pages p LEFT JOIN ?_tree_val tv ON p.tree_id=tv.tree_id");

  $smarty->assign('list',$list);
  $smarty->assign('access_add', access("add"));
  $smarty->assign('access_edit', access("edit"));
  $smarty->assign('access_delete', access("delete"));
?>