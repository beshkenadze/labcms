<?
	$news_link='http://'.$_SERVER['SERVER_NAME'].'/news';
	
	$rss=array('title'=>$config['site_name'],
				'link'=>'http://'.$_SERVER['SERVER_NAME'],
				'description'=>$config['site_desc']);
	$result=$db->select("SELECT UNIX_TIMESTAMP(news_date) as news_date, news_title, news_text, news_id 
										FROM ?_news 
										WHERE news_date<NOW() 
										AND lang_id=?
										ORDER BY news_date DESC LIMIT ?d", $core['lang_id'],intval($config['news_rss']));
	foreach ($result as $item)
	{
		$item['news_text']=strip_tags($item['news_text']);
		
		if ($config['news_anonce_length'])
		{
			if (strlen($item['news_text'])>$config['news_anonce_length'])
			{
				preg_match('/^(.{1,'.$config['news_anonce_length'].'})\s/s', $item['news_text'], $anonce);
				$item['news_text']=$anonce[1];
			}
		}
		$rss['feed'][]=array('title'=>$item['news_title'],
							'description'=>$item['news_text'],
							'link'=>$news_link.'.'.$item['news_id'].$config['ext'],
							'pubDate'=>$item['news_date']);
	}
	feed($rss, 'rss');
?>