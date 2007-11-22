<?
	$mod_template="menu.tpl";
	$first_point_id=2; //id корня всего дерева
	$deep_level=2; //глубина построения. 0 - неограниченно
	
	function menu_tree($first_point_id, $level=0)
	{
		global $db, $deep_level, $core;
		if (!$deep_level || $deep_level>$level)
		{
			$result=$db->select("SELECT t.tree_id, parent_id, tree_name, path FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE menu=1 AND parent_id=? ORDER BY pos", $first_point_id);
			if (count($result))
			{
				foreach($result as $key=>$tmp)
				{
					$tree[$key]=array(
					'name'=>$tmp['tree_name'],
					'path'=>$tmp['path'],
					'subtree'=>menu_tree($tmp['tree_id'], $level+1));
					if (in_array($tmp['tree_id'],$core['level'])) $tree[$key]['active']=1;
					if (!is_array($tree[$key]['subtree'])) unset($tree[$key]['subtree']);
				}
				return $tree;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	$tree=menu_tree($first_point_id);
	
	$smarty->assign('tree', $tree);
?>