<?php
if (strpos($_GET['action'], "comment_")===0) return; //если редактируется комментарий, то пропускаем выполнение альбома

if (in_array($_GET['action'], array('image', 'edit', 'delete')) && isset($_GET['var1']))
{
	$image_info=$db->selectRow("SELECT img_id, a.album_id, img_title, img_descr, img_date, file_name, tv.tree_id, album_name, album_descr 	tree_name, path  FROM ?_album_img ai JOIN ?_album a ON ai.album_id=a.album_id JOIN ?_tree_val tv ON a.tree_id=tv.tree_id WHERE img_id=?", $_GET['var1']);
	if (!count($image_info)) refresh("Нет такого изображения!");
	$core['nav']['path'][]=$_SERVER['PHP_SELF']."-image.".$image_info['img_id'].$config['ext'];
	$titlepage=$core['nav']['name'][]=$image_info['img_title'];
}

//храним массив необходимых размеров
$config_tn=array(array('path'=>'tn/', 'w'=>'160', h=>'160'), array('path'=>'middle/', 'w'=>'500', h=>'700'));

$smarty->assign("access_add", access("add"));
$smarty->assign("access_edit", access("edit"));
$smarty->assign("access_delete", access("delete"));

$smarty->assign("access_album_add", access("admin"));
$smarty->assign("access_album_edit", access("admin"));
$smarty->assign("access_album_delete", access("admin"));

   $albums=$db->selectCol("SELECT album_id AS ARRAY_KEY, album_name FROM ?_album"); 
   $smarty->assign("albums", $albums);

$album_cols=5;
$album_rows=2;
$config['album_path']="/albums/";
reset_session_set();
$album_info=$db->selectRow("SELECT album_id, album_name, album_descr FROM ?_album WHERE tree_id=?", $core['id']);
if (count($album_info)) $album_info['path']=$_SERVER['PHP_SELF'];

switch (true)
{
	case($_GET['action']=='add' && access("add")):
		$mode="add";
		include dirname(__FILE__)."/edit.php";
	break;
	case($_GET['action']=='edit' && access("edit")):
		$mode="edit";
		include dirname(__FILE__)."/edit.php";
	break;  
	case($_GET['action']=='delete' && access("delete")):
		$mode="delete";
		include dirname(__FILE__)."/edit.php";
	break;

	case($_GET['action']=='album_add' && access("admin")):
		$mode="add";
		include dirname(__FILE__)."/album_edit.php";
	break;
	case($_GET['action']=='album_edit' && access("admin")):
		$mode="edit";
		include dirname(__FILE__)."/album_edit.php";
	break;  
	case($_GET['action']=='album_delete' && access("admin")):
		$mode="delete";
		include dirname(__FILE__)."/album_edit.php";
	break;

	case($_GET['action']=='image'):
		if (!access("read")) refresh ("У вас нет прав для просмотра этого изображения!");
		include dirname(__FILE__)."/show.php";
	break; 
	default:
		include dirname(__FILE__)."/album.php";
}
?>