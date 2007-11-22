<?
$titlepage="Карта сайта";
$mod_template="sitemap.tpl";

function tree($id=0)
{
	global $db;
	$result=$db->select("SELECT t.tree_id, parent_id, tree_name, path FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE parent_id=? AND sitemap=1 ORDER BY pos", $id);
	if (count($result))
	{
		foreach($result as $key=>$element)
		{
				$tree[$key] = array(
				'path' => $element['path'],
				'name' => $element['tree_name'],
				'subtree' => tree($element['tree_id'])
				);
				if (!is_array($tree[$key]['subtree'])) unset($tree[$key]['subtree']);
		}
		return $tree;
	}
	else
	{
		return false;
	}
}
$tree = tree();

$smarty->assign('tree', $tree);
$smarty->assign('sitemap', true);
?>