<?php
/* echo '<?xml version="1.0" encoding="UTF-8"?>'; */
$mod_template="google_sitemap.tpl";
header("Content-type: application/xml");

function googleSiteMap($id=0, $level="")
{
 global $sitemap, $tbl_tree, $tbl_tree_val, $db;
 $i=1;
 $result=$db->select("SELECT t.tree_id, parent_id, tree_name, path FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE parent_id=? AND sitemap=1 ORDER BY pos", $id);
  if (count($result)) $tree.="\r\n<ul".((!$id)?" id='adoptme'":"").">\r\n";
 foreach($result as $var)
 {
  
  $sitemap[$var['tree_id']]["tree_name"] = $var['tree_name'];
  $sitemap[$var['tree_id']]["tree_path"] = $var['path'];
  googleSiteMap($var['tree_id'], $level.$i);
  $i++;
 }
}
googleSiteMap();
$smarty->assign("map",$sitemap);
?>