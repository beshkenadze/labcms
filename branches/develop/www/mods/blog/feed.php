<?php
/*
 * Created on flex 16.06.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */

$result=$db->select("SELECT b.`blog_date`,b.blog_title,b.blog_text,b.blog_id,a.login, a.user_id FROM ?_blog b, ?_users a WHERE `blog_date`<=NOW() AND a.user_id = b.user_id ORDER BY blog_date DESC LIMIT 0, ?d", $config['blog_at_page']);
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
				}
			}
			$rssItem[]=array(  'id'=>$blog_row['blog_id'],
							'date'=>date("D, M j Y H:i:s +0300",strtotime($blog_row['blog_date'])),
							'title'=>$blog_row['blog_title'],
							'text'=>($blog_row['blog_text']),
							'author'=>$blog_row['login']);
}

?>
