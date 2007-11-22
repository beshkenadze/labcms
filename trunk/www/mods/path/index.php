<?
$mod_template='default.tpl';
$result=$db->select("SELECT tree_id, path, tree_name FROM ?_tree_val WHERE tree_id IN (?a) AND `show`=1", $core['level']);
$path=$name=array();
foreach($result as $var)
{
 $key=array_search($var['tree_id'],$core['level']);
 $path[$key]=$var['path'];
 $name[$key]=bbcode($var['tree_name']);
}
ksort($path);
if (count($core['nav']['path']))
{
 foreach($core['nav']['name'] as $key=>$val)
 {
  $core['nav']['name'][$key]=bbcode($val);
 }
 $path=array_merge($path, $core['nav']['path']);
 $name=array_merge($name, $core['nav']['name']);
}
$smarty->assign('path', $path);
$smarty->assign('name', $name);
?>