<?
$mod_template="edit.tpl";
if (access('edit') || access('add')) $_SESSION['access_files']=1;
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
	$error=array();

	$title=trim($_POST['title']);
	$content=trim($_POST['page_content']);
	$path=trim($_POST['path']);
	$parent_id=intval($_POST['parent_id']);


	if (!$title)
	{
		$error[]="Не введено название страницы";
	}

	if (!$content)
	{
		$error[]="Не введен текст страницы";
	}

	if ($path)
	{
		$path=convert_url($path);
	}
	else
	{
		$path=convert_url($title);
	}


	if (!count($error))
	{
		if($mode=="edit")
		{
			$query=array('page_title'=>$title,
			'page_text'=>$content,
			'tree_id'=>$_POST['tree_id']);
			$db->query("UPDATE ?_pages SET ?a WHERE page_id=?", $query, $page_id);
			$query=array('path'=>$path);
			$db->query("UPDATE ?_tree_val tv, ?_pages p SET ?a  WHERE tv.tree_id=p.tree_id AND p.page_id=?", $query, $page_id);
			$db->query("UPDATE ?_tree SET parent_id=?  WHERE tree_id=?", $parent_id, $_POST['tree_id']);
		}

		if($mode=="add")
		{
			$tree_id=$db->query("INSERT INTO ?_tree SET parent_id=?", $parent_id);
			$query=array('tree_id'=>$tree_id,
			'tree_name'=>$title,
			'path'=>$path,
			'template'=>'default');
			$db->query("INSERT INTO ?_tree_val SET ?a", $query);
			$query=array('tree_id'=>$tree_id,
			'page_title'=>$title,
			'page_text'=>$content);
			$db->query("INSERT INTO ?_pages SET ?a", $query);
			$query=array('tree_id'=>$tree_id,
			'module_id'=>$core['inc']['module_id']);
			$db->query("INSERT INTO ?_includes SET ?a", $query);
		}
		refresh();
	}
}
if ($mode=="delete")
{
	$db->query("DELETE FROM ?_pages WHERE page_id=?", $page_id);
	$db->query("UPDATE ?_tree_val SET menu=0, sitemap=0,  `show`=0  WHERE tree_id=?",$page_info['tree_id']);
	refresh();
}


//include $_SERVER["DOCUMENT_ROOT"]."/spaw2/spaw.inc.php";
if ($mode=="edit")
{

	if (!count($error))
	{
		$data=$db->selectRow("SELECT page_text as content, page_title as title, t.tree_id, path, page_id, parent_id FROM ?_pages p LEFT JOIN ?_tree_val tv ON p.tree_id=tv.tree_id LEFT JOIN ?_tree t ON tv.tree_id=t.tree_id WHERE page_id=?", $page_id);
		if (!$data) puterror("нет такой статьи", 0);
		$Value = $data['content'];
		$smarty->assign($data);
		$smarty->assign('parent_id_sel', $data['parent_id']);
	}
	else
	{
		$Value = $_POST['page_content'];
	}
}

if($mode=="add")
{
	if ($_POST['page_content']) $Value = $_POST['page_content'];
}

//SpawConfig::setStaticConfigItem('default_toolbarset','mini');

/* $spaw = new SpawEditor("page_content",$Value);

$spaw->setConfigItem(
  'PG_SPAWFM_SETTINGS',
    array(
      'allow_upload' => true,
      'recursive' => true,
      'allow_modify_subdirectories' => true,
      'allow_create_subdirectories' => true,
      'chmod_to' => true,
      'max_upload_filesize' => 0,
      'allowed_filetypes' => array('images', 'flash', 'documents'),
    ),
  SPAW_CFG_TRANSFER_SECURE
);

 $spawn_content = $spaw->getHtml();*/

$smarty->assign("page_content", $Value);
$smarty->assign("errors", $error);

function select_tree($parent_id=0, $level=0)
{
	global $page_info, $parent_select, $db;
	$result=$db->select("SELECT t.tree_id,  tree_name,  pos FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id  WHERE t.parent_id=? ORDER BY pos", $parent_id);
	foreach($result as $tree)
	{
		if ($tree['tree_id']==$page_info['tree_id']) continue;
		$margin="";
		for($i=0; $i<$level*3; $i++) $margin.="&nbsp;";
		$parent_select[$tree['tree_id']]=$margin.$tree['tree_name'];
		select_tree($tree['tree_id'], $level+1);
	}
}
$parent_select=array("");
select_tree();
$smarty->assign('parent_select', $parent_select);

?>