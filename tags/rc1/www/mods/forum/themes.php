<?
 
   $mod_template="themes.tpl";

 $count=$db->selectCell("SELECT count(*) FROM  ?_forum_themes ft WHERE ft.forum_id=?", $forum_id);
 if (!$count) $count=1;
  if ($page < 1) $page = 1;
  if ($page>$total=ceil($count/$config['forum_themes_at_page'])) $page=$total;

  //определяем с какой страницы запрашивать
  $start=($page-1)*$config['forum_themes_at_page'];
 

 $themes=$db->select("SELECT theme_id, author, subject, total_posts, last_user, DATE_FORMAT(last_post, '%d.%m.%Y %H:%m:%s') as last_post, last_post as lastpost FROM ?_forum_themes WHERE forum_id=? ORDER BY lastpost DESC LIMIT ?d, ?d", $forum_id, $start, $config['forum_themes_at_page']);
 foreach($themes as $theme)
 {
  $smarty->append('themes', array(
  'theme_id'=>$theme['theme_id'],
  'total_posts'=>$theme['total_posts'],
  'total_pages'=>ceil($theme['total_posts']/$config['forum_posts_at_page']),
  'last_post'=>$theme['last_post'],
  'author'=>text_string($theme['author']),
  'last_user'=>text_string($theme['last_user']),
  'subject'=>bbcode($theme['subject']),
));
 }
 $smarty->assign("current_page", $page);
 $smarty->assign("total", $total);
 $smarty->assign("forum_id", $forum_id);

?>