<?
setlocale(LC_CTYPE , "ru_RU.CP1251");

   $mod_template="themes.tpl";

if (!$_GET['search']) $_GET['search']=$_GET['var3'];

//разделяем фразу на отдельные слова, выделяем у них корень и составляем поисковый запрос
$text_array=explode(" ", preg_replace('/[\s]+/',' ',trim($_GET['search'])));
$stemmer = new Lingua_Stem_Ru();

//формируем условия для всех слов
foreach ($text_array as $val)
{
 $query_text.="+".$stemmer->stem_word($val)."* ";
}

//узнаем количество страниц
$count=$db->selectCell("SELECT count(DISTINCT(ft.theme_id)) FROM ?_forum_posts fp JOIN ?_forum_themes ft ON fp.theme_id=ft.theme_id WHERE (MATCH(fp.user_name, fp.msg) AGAINST(? IN BOOLEAN MODE) OR MATCH(ft.subject) AGAINST(? IN BOOLEAN MODE)) { AND ft.forum_id=?}", $query_text, $query_text, (($forum_info['forum_id'])?$forum_info['forum_id']:DBSIMPLE_SKIP));
if ($count)
{
  if ($page < 1) $page = 1;
  if ($page>$total=ceil($count/$config['forum_themes_at_page'])) $page=$total;

  //определяем с какой страницы запрашивать
  $start=($page-1)*$config['forum_themes_at_page'];

  if (!$forum_info['forum_id']) $additional_fields=" ff.forum_id, ff.forum_name,";
  
//все результаты поиска
$result=$db->select("SELECT ft.theme_id, $additional_fields author, subject, ft.total_posts, ft.last_user, DATE_FORMAT(ft.last_post, '%d.%m.%Y %H:%m:%s') as last_post, ft.last_post as lastpost FROM ?_forum_posts fp JOIN ?_forum_themes ft ON fp.theme_id=ft.theme_id JOIN ?_forum_forums ff ON ff.forum_id=ft.forum_id WHERE (MATCH(fp.user_name, fp.msg) AGAINST(? IN BOOLEAN MODE) OR MATCH(ft.subject) AGAINST(? IN BOOLEAN MODE)) $forum_where GROUP BY ft.theme_id ORDER BY lastpost DESC LIMIT ?d, ?d", $query_text, $query_text, $start, $config['forum_themes_at_page']);

 foreach($result as $tmp)
 {
	$tmp['subject']=text_string($tmp['subject'], $text_array);
	$tmp['author']=text_string($tmp['author'], $text_array); 
	$tmp['last_user']=text_string($tmp['last_user'], $text_array);
	$themes[]=$tmp;
 }

 $smarty->assign('themes', $themes);
 $smarty->assign("current_page", $page);
 $smarty->assign("total", $total);
}
else
{
 $smarty->assign("no_result",1);
}

 $smarty->assign("forum_id", $forum_id);

?>