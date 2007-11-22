<?
if ($_SERVER['REQUEST_METHOD']=='POST')
{
	if ($_POST['move_img'] && access('edit'))
	{
		if (count($_POST['img_id']))
		{
			$db->query("UPDATE ?_album_img SET album_id=? WHERE img_id IN (?a)", $_POST['album_id'], array_keys($_POST['img_id']));
			refresh();
		}
	}
	
	if ($_POST['delete_img'] && access('delete'))
	{
		if (count($_POST['img_id']))
		{
			$files=$db->selectCol("SELECT file_name FROM ?_album_img WHERE img_id IN (?a)", array_keys($_POST['img_id']));
			foreach($files as $file)
			{
				//удаляем оригинал
				unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$file);
				//удаляем превьюхи
				foreach ($config_tn as $tn)
				{
					unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$tn['path'].$file);
				}
			}
			$db->query("DELETE FROM ?_album_img WHERE img_id IN (?a)", array_keys($_POST['img_id']));
			refresh();
		}
	}
}

    $page=intval($_GET['var1']);
   if ($album_info['album_id']) //если передан идентификатор альбома, то пытаемся его показать
   {
    $result=$db->selectRow("SELECT count(img_id) as total, album_name FROM ?_album a LEFT JOIN ?_album_img ai ON a.album_id=ai.album_id WHERE a.album_id=? GROUP BY a.album_id", $album_info['album_id']);
    if (count($result))
    {
	 $total			=$result['total'];
	 $album_title	=$result['album_name'];

     $smarty->assign("album_title", $album_title);

	 $mod_template="album.tpl";
	 if ($total)
	 {
	     $limit=$album_cols*$album_rows;
	     $total_pages=ceil($total/$limit);
	     if ($page<1) $page=1;
	     if ($page>$total_pages) $page=$total_pages;
	   
	     $start=($page-1)*$limit;

	     $result=$db->select("SELECT img_id, img_title, img_descr, file_name  FROM ?_album_img WHERE album_id=? ORDER BY img_id DESC LIMIT ?d, ?d", $album_info['album_id'], $start, $limit);

	     for ($i=0; $i<$album_rows; $i++)
	     {
	      for ($j=0; $j<$album_cols; $j++)
	      {
	       if($imgs=array_shift($result))
	       {
	        $images[$i][$j]=array('img_id'=>$imgs['img_id'], 'title'=>$imgs['img_title'], 'descr'=>$imgs['img_descr'], 'file_name'=>$imgs['file_name'], 'tn_name'=>$config['album_path']."tn/".$imgs['file_name'], 'link'=>$_SERVER['PHP_SELF'].".".$imgs['img_id'].$config['ext']);
	       }
	       else
	       {
	        $images[$i][$j]=array('id'=>'', 'title'=>'', 'descr'=>'', 'file_name'=>'', 'tn_name'=>'');
	       }
	      }
	     }
	    $smarty->assign('total', $total_pages); 
	    $smarty->assign('current_page', $page); 
	    $smarty->assign("images", $images);
	}
    }
    else
    {
     $album_info['album_id']=0;
    }
   }

   if (!$album_info['album_id']) //если идентификатор альбома равен 0, показываем список альбомов
   {
    $mod_template="albums.tpl";
    $albums=$db->select("SELECT path, album_name, album_descr FROM ?_album a JOIN ?_tree_val tv ON a.tree_id=tv.tree_id WHERE `show`=1 AND menu=1 ORDER BY pos");
    $smarty->assign("albums", $albums);
   }
   	$smarty->assign("access_add", access("add"));
	$smarty->assign("access_edit", access("edit"));
	$smarty->assign("access_delete", access("delete"));
?>