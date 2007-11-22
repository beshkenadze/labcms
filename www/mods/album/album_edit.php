<?
$mod_template="album_edit.tpl";

if ($_SERVER['REQUEST_METHOD']=='POST')
{
	$errors=array();
	if (!$_POST['album_name'])
	{
		$errors[]="Имя альбома не может быть пустым!";
	}
	
	$_POST['path']=convert_url($_POST['path']);
	
	if (check_url($_POST['path'], $core['id']))
	{
		if (!$_POST['confirm_path']) $errors[]="Такой URL уже существует в стстеме!";
		$smarty->assign('confirm_path', true);
	}
	
	
	if ($mode=="edit")
	{
		if (!count($errors))
		{
			$param=array(	'album_name'=>$_POST['album_name'],
							'album_descr'=>$_POST['album_descr']);
			$db->query("UPDATE ?_album SET ?a WHERE album_id=?", $param, $_POST['album_id']);
			$db->query("UPDATE ?_tree_val SET path=? WHERE tree_id=?", $_POST['path'],$core['id']);
			refresh();
		}
	}
	if ($mode=="add")
	{
		if (!count($errors))
		{
			
			$tree_id=$db->query("INSERT INTO ?_tree VALUES(NULL, ?)", $core['id']);
			$db->query("INSERT INTO ?_tree_val SET path=?, tree_id=?, tree_name=?, `show`=1, sitemap=1, menu=1", $_POST['path'], $tree_id, $_POST['album_name']);
			$param=array(	'album_name'=>$_POST['album_name'],
							'album_descr'=>$_POST['album_descr'],
							'tree_id'=>$tree_id);
			$album_id=$db->query("INSERT INTO ?_album SET ?a", $param);
			refresh('', $_POST['path']);
		}		
	}
}
else
{
$smarty->assign($album_info);
}

if ($album_info)
{
	$core['nav']['path'][]=$_SERVER['PHP_SELF']."-album_edit".$config['ext'];
	$titlepage=$core['nav']['name'][]="Редактирование альбома";
}
else
{
	$core['nav']['path'][]=$_SERVER['PHP_SELF']."-album_add".$config['ext'];
	$titlepage=$core['nav']['name'][]="Создание нового альбома";
}

if ($mode=="delete")
{
	$files=$db->selectCol("SELECT file_name FROM ?_album_img WHERE album_id=?", $album_info['album_id']);
	if (count($files))
	{
		foreach ($files as $file)
		{
			//удаляем оригинал
			unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$file);
			//удаляем превьюхи
			foreach ($config_tn as $tn)
			{
				unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$tn['path'].$file);
			}
		}
	}
	$db->query("DELETE FROM ?_album_img WHERE album_id=?", $album_info['album_id']);
	$db->query("DELETE FROM ?_album WHERE album_id=?", $album_info['album_id']);
	$db->query("UPDATE ?_tree_val SET tree_name='удален', menu=0, sitemap=0, `show`=0 WHERE tree_id=?", $core['id']);
	$refresh_path=$db->selectCell("SELECT path FROM ?_tree_val WHERE tree_id=?", $core['parent_id']);
	refresh('',$refresh_path);
}
	

?>