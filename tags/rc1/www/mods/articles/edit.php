<?
$mod_template="art_edit.tpl";
if (access('edit') || access('add')) $_SESSION['access_files']=1;
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
 $error=array();

   $art_name=trim($_POST['art_name']);
   $art_title=trim($_POST['art_title']);
   $art_content=trim($_POST['art_content']);
   $art_date=trim($_POST['art_date']);
   $art_path=trim($_POST['art_path']);

  if (!$art_name)
  {
   $error[]="Не введено название статьи";
  }

  if (!$art_title)
  {
   $error[]="Не введен заголовок окна";
  }

  if (!$art_content)
  {
   $error[]="Не введен текст статьи";
  }

  if (!preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}/', $art_date))
  {
   $error[]="Не правильный формат даты";
  }

	if ($art_path)
	{
		$art_path=convert_url($art_path);
	}
	else
	{
		$art_path=convert_url($art_title);
	}

  if (!count($error))
  {
  if($mode=="edit")
  {
   $query=array('art_name'=>$art_name,
				'art_title'=>$art_title,
				'art_content'=>$art_content,
				'art_date'=>$art_date);
   $db->query("UPDATE ?_articles SET ?a WHERE art_id=?", $query, $art_id);
   $query=array('tree_name'=>$art_title,
				'path'=>$art_path);
   $db->query("UPDATE ?_tree_val tv, ?_articles a SET ?a  WHERE tv.tree_id=a.tree_id AND a.art_id=?", $query, $art_id);
   refresh('ok', $art_path);
  }

  if($mode=="add")
  {
   $tree_id=$db->query("INSERT INTO ?_tree SET parent_id=?", $core['id']);
   $query=array('tree_id'=>$tree_id,
				'tree_name'=>$art_title,
				'menu'=>1,
				'sitemap'=>1,
				'path'=>$art_path,
				'show'=>1);
   $db->query("INSERT INTO ?_tree_val SET ?a", $query);
   $query=array('tree_id'=>$tree_id,
				'art_date'=>$art_date,
				'art_title'=>$art_title,
				'art_name'=>$art_name,
				'art_content'=>$art_content);
   $db->query("INSERT INTO ?_articles SET ?a", $query);
  }
  refresh('ok', $art_path);
  }
}
 if ($mode=="delete")
 {
  $db->query("DELETE t, tv, a FROM ?_tree t, ?_tree_val tv, ?_articles a WHERE t.tree_id=tv.tree_id AND t.tree_id=a.tree_id AND a.art_id=?", $art_id);
  refresh();
 }



if ($mode=="edit")
{
 if (!count($error))
 {
  $art_data=$db->selectRow("SELECT * FROM ?_articles a JOIN ?_tree_val tv ON a.tree_id=tv.tree_id WHERE art_id=?", $art_id);
  if (!count($art_data)) puterror("нет такой статьи", 0);
  $Value = $art_data['art_content'];
 $smarty->assign(array("art_name"=>$art_data['art_name'], "art_title"=>$art_data['art_title'], "art_date"=>$art_data['art_date'], "art_path"=>$art_data['path']));
 }
 else
 {
  $Value = $_POST['art_content'];
 }
	$core['nav']['path'][]="";
	$core['nav']['name'][]="редактирование статьи";
}

if($mode=="add")
{
  if (!$_POST['art_date']) $smarty->assign("art_date", date("Y-m-d H:i:s"));
  if ($_POST['art_content']) $Value = $_POST['art_content'];

	$core['nav']['path'][]="";
	$core['nav']['name'][]="добавление статьи";
}

 $smarty->assign("art_content", $Value);
 $smarty->assign("errors", $error);
?>