<?
//запрос количества тем
$search=$db->selectCol("SELECT DISTINCT(ft.theme_id) FROM ?_forum_posts fp JOIN ?_forum_themes ft ON fp.theme_id=ft.theme_id WHERE (MATCH(fp.msg) AGAINST(? IN BOOLEAN MODE) OR MATCH(ft.subject) AGAINST(? IN BOOLEAN MODE))", $query_text, $query_text);

/**************************/
/*  обязательный фрагмент */
$search_count=count($search);
$count+=$search_count;
	//запрос тем форума
	if ($search_count && ($search_count-$start)>0 && $limit>0)
	{
/*    конец  фрагмента    */
/**************************/

		$path_tmp=$db->selectCell("SELECT path FROM ?_includes ai, ?_tree_val tv WHERE (ai.tree_id=tv.tree_id OR ai.group_id=tv.group_id) AND module_id=? LIMIT 1", $search_module['module_id']);
		$results=$db->select("SELECT theme_id, subject FROM ?_forum_themes WHERE theme_id IN (?a) ORDER BY  last_post DESC LIMIT ?d, ?d", $search, $start, $limit);
		$search_result=array();
		foreach($results as $result)
		{
				$search_result[]=array('name'=>bbcode($result['subject']), 'path'=>$path_tmp."-theme.".$result['theme_id']."/1/".urlencode($_GET['search'])."/");
		}

/**************************/
/*  обязательный фрагмент */
		$smarty->append('search_result', $search_result);
		$smarty->append('module_name', $search_module['name']);
		$start=0;		
		$limit-=count($search_result);
	}	
	else
	{
		$start-=$search_count;
	}
/*    конец  фрагмента    */
/**************************/
?>