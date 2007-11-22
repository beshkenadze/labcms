<?php

$titlepage = "Списки записей Блога";
if ($blog_id)
{
	$mod_template="entry.tpl";
	$blog_row=$db->select("SELECT b.`blog_date`, b.blog_title, b.blog_text, b.blog_id,u.user_id, u.login, tv.path blog_path FROM ?_blog b, ?_users u,?_tree_val tv WHERE b.blog_id=? AND b.user_id=u.user_id AND b.tree_id=tv.tree_id", $blog_id);
	$titlepage = "Блог: ".$blog_row[0]["blog_title"];
			$anonce=0;
			$blog[]=array('blog_id'=>$blog_row[0]['blog_id'],
							'blog_date'=>$blog_row[0]['blog_date'],
							'blog_title'=>$blog_row[0]['blog_title'],
							'blog_text'=>$blog_row[0]['blog_text'],
							'blog_author'=>$blog_row[0]['login'],
							'blog_author_id'=>$blog_row[0]['user_id'],
							'blog_path'=>$blog_row[0]['blog_path'],
							'anonce'=>$anonce);

	if($_GET["var1"]=="entry"){
		$core['nav']['path'][]= "";
		$core['nav']['name'][]= $blog[0]["blog_title"];
	}
	$core['comment']['module_id']=$core['inc']['module_id'];
	$core['comment']['item_id']=$blog[0]['blog_id']; // идентификатор текущей записи
}
else
{
	$mod_template="blog.tpl";
	$count=$db->selectCell("SELECT COUNT(blog_id) FROM ?_blog WHERE `blog_date`<=NOW()");
	if ($count)
	{
		if ($page < 1) $page = 1;
		if ($page>$total=ceil($count/$config['blog_at_page'])) $page=$total;

		//определяем с какой страницы запрашивать
		$start=($page-1)*$config['blog_at_page'];

		$result=$db->select("SELECT b.`blog_date`,b.blog_title,b.blog_text,b.blog_id,a.login, a.user_id, tv.path blog_path FROM ?_blog b, ?_users a,?_tree_val tv WHERE `blog_date`<=NOW() AND a.user_id = b.user_id AND b.tree_id=tv.tree_id ORDER BY blog_date DESC LIMIT ?d, ?d", $start, $config['blog_at_page']);

		foreach($result as $blog_row)
		{
			$anonce=0;
			if ($config['blog_anonce_length'])
			{
				$blog_row['blog_text']=strip_tags($blog_row['blog_text']);
				if (strlen($blog_row['blog_text'])>$config['blog_anonce_length'])
				{
					preg_match('/^(.{1,'.$config['blog_anonce_length'].'})\s/s', $blog_row['blog_text'], $anonce);
					$blog_row['blog_text']=$anonce[1];
					$anonce=1;
				}
			}
			$blog[]=array('blog_id'=>$blog_row['blog_id'],
							'blog_date'=>$blog_row['blog_date'],
							'blog_title'=>$blog_row['blog_title'],
							'blog_text'=>$blog_row['blog_text'],
							'blog_author'=>$blog_row['login'],
							'blog_author_id'=>$blog_row['user_id'],
							'blog_path'=>$blog_row['blog_path'],
							'anonce'=>$anonce);
	$core['comment']['item_id'][]=$blog_row['blog_id']; // идентификаторы записией

		}

	$core['comment']['module_id']=$core['inc']['module_id'];
	

		$smarty->assign("current_page", $page);
		$smarty->assign("total", $total);
	}
}

$smarty->assign("blog", $blog);
$smarty->assign("access_add", access('add'));
$smarty->assign("access_edit", access('edit'));
$smarty->assign("access_delete", access('delete'));
?>
