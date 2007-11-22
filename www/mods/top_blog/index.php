<?
    $mod_template="top_blog.tpl";
	 $result=$db->select("SELECT b.blog_date, b.blog_title, b.blog_text, b.blog_id, u.login FROM ?_blog b, ?_users u WHERE blog_date<=NOW() AND b.user_id = u.user_id ORDER BY blog_date DESC LIMIT ?d", $config['top_blog']);
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
						'anonce'=>$anonce);
	}
$smarty->assign('top_blog', $blog);

$smarty->assign("access_add", access('add'));
$smarty->assign("access_edit", access('edit'));
$smarty->assign("access_delete", access('delete'));
?>