<?
    $mod_template="top_news.tpl";
	 $result=$db->select("SELECT news_date, news_title, news_text, news_id FROM ?_news WHERE news_date<=NOW() ORDER BY news_date DESC LIMIT ?d", $config['top_news']);
	$news=array();
	foreach($result as $news_row)
	{
		$anonce=0;
		if ($config['news_anonce_length'])
		{
			$news_row['news_text']=strip_tags($news_row['news_text']);
			if (strlen($news_row['news_text'])>$config['news_anonce_length'])
			{
				preg_match('/^(.{1,'.$config['news_anonce_length'].'})\s/s', $news_row['news_text'], $anonce);
				$news_row['news_text']=$anonce[1];
				$anonce=1;
			}
		}
		$news[]=array('news_id'=>$news_row['news_id'],
						'news_date'=>$news_row['news_date'], 
						'news_title'=>$news_row['news_title'], 
						'news_text'=>$news_row['news_text'],
						'anonce'=>$anonce);
	}
$smarty->assign('top_news', $news);

?>