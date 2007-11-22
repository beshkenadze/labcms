<?php
if (strpos($_GET['action'], "comment_")===0) return;
$art_id=intval($_GET['var1']);
if ($art_id)
{
  $art_info=$db->selectRow("SELECT * FROM ?_articles WHERE art_id=?", $art_id);
 if (!count($art_info))
 {
  puterror("Нет такой статьи",0);
 }
}
else
{
	$art_info=$db->selectRow("SELECT * FROM ?_articles WHERE tree_id=?", $core['id']);
}
  $parent_id=($art_info['art_id'] ? $core['parent_id'] : $core['id']);
  $art_list=$db->select("SELECT t.tree_id, tv.path, a.art_name, a.art_id FROM ?_tree t, ?_tree_val tv, ?_articles a WHERE t.tree_id = tv.tree_id AND tv.tree_id=a.tree_id AND parent_id =? AND `show`=1 AND menu=1", $parent_id);

  switch (true)
  {
   case((!$_GET['action'] || strpos($_GET['action'], "ajax")) && count($art_info) && access("read")):
   include dirname(__FILE__)."/show.php";

	$core['comment']['module_id']=$core['inc']['module_id'];
	$core['comment']['item_id']=$art_info['art_id']; // идентификатор текущей статьи

   break;

   case($_GET['action']=="add" && access("add")):
   $mode="add";
   include dirname(__FILE__)."/edit.php";
   break;

   case($_GET['action']=="edit" && access('edit') && $art_id):
   $mode="edit";
   include dirname(__FILE__)."/edit.php";
   break;

   case($_GET['action']=="delete" && access('delete')  && $art_id):
   $mode="delete";
   include dirname(__FILE__)."/edit.php";
   break;

   default:
   include dirname(__FILE__)."/list.php";
  }
?>