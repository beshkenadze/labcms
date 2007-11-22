<?

$mod_template="image.tpl";
$smarty->assign(array('img_title'=>$image_info['img_title'], 'img_path'=>$image_info['file_name'], 'img_descr'=>$image_info['img_descr'], 'album_title'=>$image_info['album_name'], 'album_link'=>$image_info['path'], 'img_id'=>$image_info['img_id'])); 

$prev=$db->selectRow("SELECT * FROM ?_album_img WHERE album_id=? AND img_id<? ORDER by img_id DESC LIMIT 1", $image_info['album_id'], $image_info['img_id']);
if (count($prev))
{
	$smarty->assign(array('prev_id'=>$prev['img_id'], 'prev_tn'=>$prev['file_name'], 'prev_title'=>$prev['img_title']));
}
$next=$db->selectRow("SELECT * FROM ?_album_img WHERE album_id=? AND img_id>? ORDER by img_id LIMIT 1", $image_info['album_id'], $image_info['img_id']);
if (count($next))
{
	$smarty->assign(array('next_id'=>$next['img_id'], 'next_tn'=>$next['file_name'], 'next_title'=>$next['img_title']));
}

?>