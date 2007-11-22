<?
  $titlepage=_lang('Гостевая книга');
  $mod_template="guest.tpl";

  // Извлекаем из строки запроса параметр start
  $page = intval($_GET['var1']);

  // Запрашиваем общее число отображаемых сообщейний
  $count = $db->selectCell("SELECT count(*) FROM ?_guest");

  if ($page>$total=ceil($count/$config['guestbook_posts_at_page'])) $page=$total;
  if ($page < 1) $page = 1;

  //определяем с какой страницы запрашивать
  $start=($page-1)*$config['guestbook_posts_at_page'];

  // Запрашиваем сами сообщения
  $result = $db->select("SELECT msg_id, IF (g.user_id,login,name) as name, IF (g.user_id,u.email,g.email) as email, msg, answer, `date`, INET_NTOA(ip) as ip FROM ?_guest g LEFT JOIN ?_users u ON g.user_id=u.user_id ORDER BY `date` DESC LIMIT ?d, ?d", $start, $config['guestbook_posts_at_page']);

  $posts=array();
  foreach($result as $post)
  {
    // Вытаскиваем переменные из базы данных
	$posts[]=array(	'email'=>text_string($post['email']), 
					'name'=>text_string($post['name']), 
					'date'=>$post['date'], 
					'msg'=>bbcode($post['msg']), 
					'answer'=>bbcode($post['answer']), 
					'msg_id'=>$post['msg_id'], 
					'ip'=>$post['ip']);

 }
$smarty->assign("posts", $posts);

$smarty->assign(array(	"access_admin"=>access("edit"),
						"access_edit"=>access("edit"),
						"access_add"=>access("add"),
						"access_delete"=>access("delete")));

$smarty->assign("current_page", $page);
$smarty->assign("total", $total);

?>