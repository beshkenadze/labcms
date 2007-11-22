<?
//запрос количества картинок
$search=$db->selectCol("SELECT ai.img_id FROM ?_album_img ai WHERE MATCH(img_descr, img_title) AGAINST(? IN BOOLEAN MODE)", $query_text);

/**************************/
/*  обязательный фрагмент */
$search_count=count($search);
$count+=$search_count;
	//запрос тем форума
	if ($search_count && ($search_count-$start)>0 && $limit>0)
	{
/*    конец  фрагмента    */
/**************************/

		$album_result=$db->select("SELECT img_id, img_title, path FROM ?_album_img ai JOIN ?_album a ON ai.album_id=a.album_id JOIN ?_tree_val tv ON a.tree_id=tv.tree_id WHERE img_id IN (?a) LIMIT ?d, ?d", $search, $start, $limit);
		$search_result=array();
		foreach($album_result as $result)
		{
			$search_result[]=array('name'=>($result['img_title']?$result['img_title']:"Без названия"), 'path'=>$result['path']."_image.".$result['img_id']."/#photo");
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