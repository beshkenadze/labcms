<?

if ($_POST['change_forum']) refresh('', $_SERVER['PHP_SELF'].".".$_POST['change_forum'].$config['ext']);

if (!$_GET['action'] || in_array($_GET['action'], array('search', 'new', 'edit_forum', 'delete_forum'))) $forum_id=intval($_GET['var1']);
elseif (in_array($_GET['action'], array('theme', 'delete_theme'))) $theme_id=intval($_GET['var1']);
else $post_id=intval($_GET['var1']);

$page=intval($_GET['var2']);

if ($post_id)
{
	$forum_info=$db->selectRow("SELECT * FROM ?_forum_posts fp JOIN  ?_forum_themes ft ON fp.theme_id=ft.theme_id JOIN ?_forum_forums ff ON ft.forum_id=ff.forum_id WHERE fp.post_id=?", $post_id);
	if (!count($forum_info)) refresh('нет такого сообщения!');
} 
elseif ($theme_id)
{
	$forum_info=$db->selectRow("SELECT * FROM ?_forum_themes ft JOIN ?_forum_forums ff ON ft.forum_id=ff.forum_id WHERE ft.theme_id=?", $theme_id);
	if (!count($forum_info)) refresh('нет такой темы!');
}
elseif($forum_id)
{
	$forum_info=$db->selectRow("SELECT * FROM ?_forum_forums ff WHERE ff.forum_id=?", $forum_id);
	if (!count($forum_info)) refresh('нет такого форума!');
}

if ($forum_info['forum_id'])
{
	$core['nav']['path'][]=$_SERVER['PHP_SELF'].".".$forum_info['forum_id'].$config['ext'];
	$core['nav']['name'][]=$forum_info['forum_name'];
}
if ($forum_info['theme_id'])
{
	$core['nav']['path'][]=$_SERVER['PHP_SELF']."-theme.".$forum_info['theme_id']."/1/";
	$core['nav']['name'][]=$forum_info['subject'];
}

$smarty->assign('access_admin', access("admin"));
$smarty->assign('access_edit', access("edit"));
$smarty->assign('access_delete', access("delete"));
$smarty->assign('access_add', access("msg_add"));


function show_post($row_info, $access_edit=0, $access_delete=0)
{
	$post_info=array('post_id'=>$row_info['post_id'],
	'user_name'=>text_string($row_info['user_name']),
	'msg'=>bbcode_all($row_info['msg'], $_GET['search']),
	'email'=>text_string($row_info['email']),
	'putdate'=>$row_info['date'],
	'ip'=>$row_info['ip'],
	'access_delete'=>$access_delete,
	'access_add'=>$access_add,
	'access_edit'=>$access_edit);
	return $post_info;
}

function change_forum($forum_id)
{
	global $db, $smarty;
	$result=$db->selectCol("SELECT forum_id AS ARRAY_KEY, forum_name FROM ?_forum_forums {WHERE closed=?}", (access("read")?DBSIMPLE_SKIP:0));
	$smarty->assign('select_forum', $result);
	//$smarty->assign('current_forum', $forum_id);
}
change_forum($forum_info['forum_id']);

switch (true)
{
	case(!$_GET['action'] && $forum_id):
		if (!access("msg_read")) refresh('Вы не можете просматривать данный форум!');
		include dirname(__FILE__)."/themes.php";
	break;
	
	case($_GET['action']=='theme'):
		if (!access("msg_read")) refresh('Вы не можете просматривать данную тему!');
		include dirname(__FILE__)."/posts.php";
	break;

	case($_GET['action']=='edit'):
		if ((!access("msg_edit") || (access("msg_edit") && $forum_info['user_id']!=$user_info['user_info'])) && !access("edit")) refresh('Вы не можете редактировать это сообщение!');
		$mode="edit";
		$core['nav']['path'][]="";
		$core['nav']['name'][]="редактирование сообщения";
		include dirname(__FILE__)."/edit_post.php";
	break;

	case($_GET['action']=='delete'):
		if ((!access('msg_delete') || $forum_info['user_id']!=$user_info['user_info']) && !access("delete")) refresh('Вы не можете удалить это сообщение!');
		$mode="delete";
		include dirname(__FILE__)."/edit_post.php";
	break;
	
	case($_GET['action']=='delete_theme'):
		if (!access("delete")) refresh('Вы не можете удалять темы!');
		$mode="delete_theme";
		include dirname(__FILE__)."/edit_post.php";
	break;

	case($_GET['action']=='reply' && $post_id):
		if (!access("msg_add")) refresh('Вы не можете отвечать на сообщения!');
		$mode="reply";
		$core['nav']['path'][]="";
		$core['nav']['name'][]="ответ на сообщение";
		include dirname(__FILE__)."/edit_post.php";
	break;

	case($_GET['action']=='new' && $forum_id):
		if (!access("msg_add")) refresh('Вы не можете создавать темы!');
		$mode="new";
		$core['nav']['path'][]="";
		$core['nav']['name'][]="Добавление темы";
		include dirname(__FILE__)."/edit_post.php";
	break;

	case($_GET['action']=='search'):
		if (!access("msg_read")) refresh('Вы не можете пользоваться поиском!');
		$core['nav']['path'][]="";
		$core['nav']['name'][]="поиск";
		include dirname(__FILE__)."/search.php";
	break;

	case($_GET['action']=='add_forum'):
		if (!access("admin")) refresh('Вы не можете создавать форумы!');
		$mode="new";
		$core['nav']['path'][]="";
		$core['nav']['name'][]="создание нового форума";
		include dirname(__FILE__)."/edit_forum.php";
	break;

	case($_GET['action']=='edit_forum'):
		if (!access("admin")) refresh('Вы не можете редактировать форумы!');
		$mode="edit";
		$core['nav']['path'][]="";
		$core['nav']['name'][]="редактирование форума";
		include dirname(__FILE__)."/edit_forum.php";
	break;

	case($_GET['action']=='delete_forum'):
		if (!access("admin")) refresh('Вы не можете удалять форумы!');
		$mode="delete";
		include dirname(__FILE__)."/edit_forum.php";
	break;

	default:
	include dirname(__FILE__)."/forums.php";
}

$titlepage="Форум".($forum_info['forum_name']?" / ".$forum_info['forum_name']:"").($forum_info['subject']?" / ".preg_replace('/\[.*?\]/', '', $forum_info['subject']):"");
$smarty->assign('forum_info', $forum_info);
?>