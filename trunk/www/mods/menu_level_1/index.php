<?
  //модуль по созданию меню
  //для первого уровня меню установить 0
  //для второго уровня меню установить 1
  $menu_level=0; 
  
  $mod_template="menu.tpl";
	if(!$core['level'][$menu_level]) //если у элемента нет родителей, то считаем родителем его самого.
	{
	  	$menu = $db->select("SELECT tree_name,tv.tree_id, path FROM ?_tree t LEFT JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE parent_id=? AND menu=1 ORDER BY pos", $core['id']);
	}
	else
	{	
		$menu = $db->select("SELECT tree_name,tv.tree_id, path FROM ?_tree t LEFT JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE parent_id=? AND menu=1 ORDER BY pos", $core['level'][$menu_level]);
	}
	
    foreach($menu as $key=>$m) {
    	if($m["tree_id"] == $core["level"][$menu_level+1])
    	$active=$key;
    }
    if (isset($active)) $menu[$active]["active"]=1;
    $smarty->assign('menu',$menu);
?>
