<?
//запрос количества статей
$search=$db->selectCol("SELECT a.tree_id FROM ?_articles a JOIN ?_tree_val tv ON a.tree_id=tv.tree_id WHERE MATCH(art_name, art_content) AGAINST(? IN BOOLEAN MODE) AND tv.`show`=1", $query_text);

/**************************/
/*  обязательный фрагмент */
$search_count=count($search);
$count+=$search_count;
	//запрос тем форума
	if ($search_count && ($search_count-$start)>0 && $limit>0)
	{
/*    конец  фрагмента    */
/**************************/

		$search_result=$db->select("SELECT path, tree_name as name FROM ?_tree_val WHERE tree_id IN (?a) ORDER BY tree_name LIMIT ?d, ?d", $search, $start, $limit);


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