<?php
$mod_template="news.tpl";
$titlepage = "Новости";

if ($news_id)
{
	$news=$db->select("SELECT news_date, news_title, news_text, news_id FROM ?_news WHERE news_id=?", $news_id);
	$core['nav']['path'][]= "";
	$core['nav']['name'][]= $news[0]["news_title"];
	$core['comment']['module_id']=$core['inc']['module_id'];
	$core['comment']['item_id']=$news[0]['news_id']; // идентификатор текущей новости
}
else
{
	$count=$db->selectCell("SELECT COUNT(news_id) FROM ?_news WHERE `news_date`<=NOW() AND lang_id=?", $core['lang_id']);
	if ($count)
	{
		if ($page < 1) $page = 1;
		if ($page>$total=ceil($count/$config['news_at_page'])) $page=$total;

		//определяем с какой страницы запрашивать
		$start=($page-1)*$config['news_at_page'];
		if (!access('edit') || !access('delete')) $tmp_sql="WHERE `news_date`<=NOW() AND lang_id=".$core['lang_id'];
		$result=$db->select("SELECT UNIX_TIMESTAMP(news_date) as news_date, news_title, news_text, news_id FROM ?_news $tmp_sql ORDER BY news_date DESC LIMIT ?d, ?d", $start, $config['news_at_page']);
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
							'news_text'=>nl2br($news_row['news_text']),
							'anonce'=>nl2br($anonce));
		}
		$smarty->assign("current_page", $page);
		$smarty->assign("total", $total);
	}
}

$smarty->assign("news", $news);
$smarty->assign("access_add", access('add'));
$smarty->assign("access_edit", access('edit'));
$smarty->assign("access_delete", access('delete'));
?>
