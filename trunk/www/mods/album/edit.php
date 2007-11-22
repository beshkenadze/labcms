<?

    $mod_template="edit.tpl";

	if ($mode=="delete")
	{
//удаляем оригинал
		unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$image_info['file_name']);
//удаляем превьюхи
foreach ($config_tn as $tn)
{
                unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$tn['path'].$image_info['file_name']);
}

		$db->query("DELETE FROM ?_album_img WHERE img_id=?", $image_info['img_id']);
		refresh('ok', $_SERVER['PHP_SELF'].".".$image_info['album_id'].$config['ext']);
	}
	
if ($_SERVER['REQUEST_METHOD']=="POST")
{
	$errors=array();
	$album_id=$_POST['album_id'];
	$img_title=($_POST['img_title'])?$_POST['img_title']:$_FILES['file_name']['name'];
	$img_descr=$_POST['img_descr'];

	if ($mode=="edit")
	{
		if ($image_info['img_id'] && $_FILES['file_name']['size'] && !count($errors)) //если обновляем существующую фотографию новым файлом
		{
			$new_name=upload_img_file ($config['album_path'], $config_tn);

			if ($new_name)
			{
				//удаляем оригинал
				unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$image_info['file_name']);
				//удаляем превьюхи
				foreach ($config_tn as $tn)
				{
					unlink($_SERVER["DOCUMENT_ROOT"].$config['album_path'].$tn['path'].$image_info['file_name']);
				}
				$query=array(	'album_id'=>$album_id,
								'img_title'=>$img_title,
								'img_descr'=>$img_descr,
								'file_name'=>$new_name);
				$db->query("UPDATE ?_album_img SET ?a WHERE img_id=?", $query, $image_info['img_id']);
				refresh('ok', $_SERVER['PHP_SELF']."-image.".$image_info['img_id'].$config['ext']."#photo");
			}
		}

		if ($image_info['img_id'] && !$_FILES['file_name']['size'] && !count($errors)) //если обновляем данные существующей фотографии
		{
			$query=array(	'img_title'=>$img_title,
							'img_descr'=>$img_descr,
							'album_id'=>$album_id);
			$db->query("UPDATE ?_album_img SET ?a WHERE img_id=?", $query, $image_info['img_id']);
			refresh('ok',$_SERVER['PHP_SELF']."-image.".$image_info['img_id'].$config['ext']."#photo");
		}	
	
	}

	if ($mode=="add")
	{
		if (!$_FILES['file_name']['size']) //если пытаемся создать новый, но не указали файл
		{
			$errors[]="Нельзя созадвать запись без файла.";
		}

		if ($_FILES['file_name']['size'] && !count($errors))//если создаем новую запись
		{
			$new_name=upload_img_file ($config['album_path'], $config_tn);

			if($new_name)
			{
				$query=array(	'album_id'=>$album_id,
								'img_title'=>$img_title,
								'img_descr'=>$img_descr,
								'file_name'=>$new_name);
				$img_id=$db->query("INSERT INTO ?_album_img SET ?a, img_date=NOW()", $query);
				refresh('ok', $_SERVER['PHP_SELF']."-image.$img_id".$config['ext']."#photo");
			}
		}
	}
}

   if (!count($errors))
   {
    $smarty->assign($image_info);
   }
$smarty->assign("errors", $errors);

$core['nav']['path'][]=$_SERVER['PHP_SELF']."-edit.".$image_info['img_id'].$config['ext'];
$core['nav']['name'][]="Редактирование изображения";
$titlepage="Редактирование изображения";
?>