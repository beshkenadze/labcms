<?
if (access('edit') || access('add')) $_SESSION['access_files']=1;

$core['nav']['path'][]= "";
$core['nav']['name'][]= "Редактирование записи";
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
	$error=array();
	$blog['blog_title']=trim($_POST['blog_title']);
	$blog['blog_text']=trim($_POST['blog_text']);
	$blog['user_id'] = $user_info['user_id'];
	if (!$blog['blog_text'])
	{
		$errors[]="Не введен текст записи";
	}
	if($_POST['blog_date']){
		if (!preg_match('/\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}:\d{2}/', $_POST['blog_date']))
		{
			$errors[]="Неправильный формат даты";
		}
		else
			$blog_date=preg_replace('/(\d{2})\.(\d{2})\.(\d{4}) (\d{2}):(\d{2}):(\d{2})/', '$3-$2-$1 $4:$5:$6', $_POST['blog_date']);
	//exit($blog_date);
	}else{
		$blog_date= date("Y-m-d H:i:s");

	}

	if (!$errors)
	{
		if ($mode=="add")
		{
			$blog_patch = $_SERVER["PHP_SELF"].convert_url($blog['blog_title']);
			if(check_url($blog_patch)){
				$blog_patch = $blog_patch."_";
			}
			   $blog_id = $db->query("INSERT INTO ?_blog SET ?a, blog_date=?", $blog, $blog_date);
			   $tree_id=$db->query("INSERT INTO ?_tree SET parent_id=?", $core['id']);
			   $query=array('tree_id'=>$tree_id,
							'tree_name'=>$blog['blog_title'],
							'params'=>'blog_id='.$blog_id,
							'menu'=>1,
							'sitemap'=>1,
							'path'=>$blog_patch,
							'show'=>1);
			   $db->query("INSERT INTO ?_tree_val SET ?a", $query);
			   $db->query("UPDATE ?_blog SET tree_id=?d WHERE blog_id=?", $tree_id, $blog_id);
		}
		if ($mode=="edit")
		{
			$blog_patch = $_SERVER["PHP_SELF"].convert_url($blog['blog_title']);
			$query=array('tree_name'=>$blog['blog_title'],
						 'path'=>$blog_patch);
			$db->query("UPDATE ?_tree_val tv, ?_blog b SET ?a  WHERE tv.tree_id=b.tree_id AND b.blog_id=?", $query, $blog_id);
			$db->query("UPDATE ?_blog SET ?a, blog_date=? WHERE blog_id=?", $blog, $blog_date, $blog_id);
		}
		refresh('OK');
	}
}

if ($mode=="delete")
{
	$db->query("DELETE FROM ?_blog WHERE blog_id=?", $blog_id);

	refresh('OK');
}



$mod_template='edit_blog.tpl';

if ($mode=="edit")
{
	if (!count($errors))
	{
		$new=$db->selectRow("SELECT blog_title, blog_text, DATE_FORMAT(blog_date, '%d.%m.%Y %H:%i:%s') as blog_date FROM ?_blog WHERE blog_id=?", $blog_id,$user_info["user_id"]);
		$Value = $new['blog_text'];
		$smarty->assign($new);
	}
	else
	{
		$Value = $_POST['blog_text'];
	}
}

if($mode=="add")
{
	if (!$_POST['blog_date']) $smarty->assign("blog_date", date("d.m.Y H:i:s"));
	if ($_POST['blog_content']) $Value = $_POST['blog_text'];
}



$smarty->assign("blog_text", $Value);
$smarty->assign("errors", $errors);
?>