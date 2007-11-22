<?php
if (access('read'))
{
  if (isset($_GET['var1']))
  {
   include "edit.php";
  }
  $mod_template="tree.tpl";

  if($_SERVER['REQUEST_METHOD']=="POST" && access('edit'))
  {
   //уничтожаем текущие сессии
   reset_session_set();
   //изменяем видимость в меню
   if (count($_POST['menu']))
   {
    $db->query("UPDATE ?_tree_val SET menu=1 WHERE tree_id IN (?a)", array_keys($_POST['menu']));
    $db->query("UPDATE ?_tree_val SET menu=0 WHERE tree_id NOT IN (?a)", array_keys($_POST['menu']));
   }
   else
   {
    $db->query("UPDATE ?_tree_val SET menu=0");
   }

   //изменяем видимость в карте сайта
   if (count($_POST['sitemap']))
   {
    $db->query("UPDATE ?_tree_val SET sitemap=1 WHERE tree_id IN (?a)", array_keys($_POST['sitemap']));
    $db->query("UPDATE ?_tree_val SET sitemap=0 WHERE tree_id NOT IN (?a)", array_keys($_POST['sitemap']));
   }
   else
   {
    $db->query("UPDATE ?_tree_val SET sitemap=0");
   }

   //изменяем видимость на сайте
   if (count($_POST['show']))
   {
    $db->query("UPDATE ?_tree_val SET `show`=1 WHERE tree_id IN (?a)", array_keys($_POST['show']));
    $db->query("UPDATE ?_tree_val SET `show`=0 WHERE tree_id NOT IN (?a)", array_keys($_POST['show']));
   }
   else
   {
    $db->query("UPDATE ?_tree_val SET `show`=0");
   }
   //изменяем порядок сортировки
   if (count($_POST['pos']))
   foreach ($_POST['pos'] as $key=>$val)
   {
    $db->query("UPDATE ?_tree_val SET pos=? WHERE tree_id=?", $val, $key);
   }

   function recurse_id($id)
   {
    global $del_arr, $db;
    $result=$db->select("SELECT * FROM ?_tree WHERE parent_id=?", $id);
    foreach ($result as $tree)
    {
     $del_arr[]=$tree['tree_id'];
     recurse_id($tree['tree_id']);
    }
   }
   if (is_array($_POST['del']))
   foreach ($_POST['del'] as $key=>$val)
   {
    $key=intval($key);
    $del_arr=array($key);
    recurse_id($key);
    $db->query("DELETE FROM ?_tree_val WHERE tree_id IN (?a)", $del_arr);
    $db->query("DELETE FROM ?_includes WHERE tree_id IN (?a)", $del_arr);
    $db->query("DELETE FROM ?_tree WHERE tree_id IN (?a)", $del_arr);
   }
  }

  function recurse_tree($tree_id=0, $level=0)
  {
   global $tree_arr, $db;
   $result=$db->select("SELECT t.tree_id,  tree_name,  menu, pos,  `show`, sitemap, params  FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id  WHERE t.parent_id=? ORDER BY pos", $tree_id);
   foreach($result as $tree)
   {
    $menu = ($tree['menu'] ? 1 : 0);
    $show = ($tree['show'] ? 1 : 0);
    $sitemap = ($tree['sitemap'] ? 1 : 0);
if (preg_match('/(?:^|&)id=(\d+)(?:$|&)/i', $tree['params'], $link)) $link=$link[1];

    $tree_arr[]=array("name"=>$tree['tree_name'], "margin"=>$level*20, "id"=>$tree['tree_id'], "pos"=>$tree['pos'], 'menu'=>$menu, 'show'=>$show, 'sitemap'=>$sitemap, 'link'=>$link);
    recurse_tree($tree['tree_id'], $level+1, $tree_arr);
   }
  }

$result=$db->select("SELECT tv.path, tv1.tree_id, tv1.tree_name  FROM ?_tree_val tv LEFT JOIN ?_tree_val tv1 ON tv.path=tv1.path AND tv.tree_id!=tv1.tree_id AND tv1.params NOT LIKE '%id=%' AND tv.params NOT LIKE '%id=%' WHERE tv1.tree_id IS NOT NULL GROUP BY tv1.tree_id ORDER BY tv.path, tv1.tree_id");
$duples=array();
if (count($result))
{
 foreach($result as $tmp)
 $duples[$tmp['path']][]=array($tmp['tree_id'], $tmp['tree_name']);
}
$smarty->assign('duples', $duples);


$tree_arr=array();
recurse_tree();

$smarty->assign('tree_items', $tree_arr);
}
?>
