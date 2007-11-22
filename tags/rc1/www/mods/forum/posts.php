<?
 $mod_template="posts.tpl";
 
if (!$_GET['search']) $_GET['search']=$_GET['var3'];
 
 $result=$db->selectRow("SELECT count(*) as total, subject FROM  ?_forum_posts fp LEFT JOIN ?_forum_themes ft USING(theme_id) WHERE fp.theme_id=? GROUP BY fp.theme_id", $theme_id);
 $count		=$result['total'];
 $subject	=bbcode($result['subject'], $_GET['search']);

 if (!$subject) error404();

  if ($page < 1) $page = 1;
  if ($page>$total=ceil($count/$config['forum_posts_at_page'])) $page=$total;

  //определяем с какой страницы запрашивать
  $start=($page-1)*$config['forum_posts_at_page'];

 $result=$db->select("SELECT fp.post_id, fp.user_name, fp.msg, fp.email, DATE_FORMAT(fp.putdate, '%d.%m.%Y %H:%m:%s') as 'date', INET_NTOA(fp.ip) as ip, ft.forum_id  FROM ?_forum_posts fp  LEFT JOIN ?_forum_themes ft ON fp.theme_id=ft.theme_id WHERE ft.theme_id=? ORDER BY putdate LIMIT ?d, ?d", $theme_id, $start, $config['forum_posts_at_page']);
$first_post=($page==1) ? 1 : 0;
 foreach($result as $tmp)
 {
  $access_edit=(($tmp['user_name']==$user_info['login'] && access("msg_edit")) || access("edit")) ? 1 : 0;
  $access_delete=(!$first_post && (($tmp['user_name']==$user_info['login'] && access("msg_delete")) || access("delete"))) ? 1 : 0; 
  $posts[]=show_post($tmp, $access_edit, $access_delete);
  

  $forum_id=$tmp['forum_id'];
  $first_post=0;
 }

 $smarty->assign('posts', $posts); 
 $smarty->assign('subject', $subject);
 $smarty->assign("current_page", $page);
 $smarty->assign("total", $total);
 $smarty->assign("theme_id", $theme_id);
?>