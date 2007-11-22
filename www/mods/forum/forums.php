<?
 
   $mod_template="forums.tpl";

 $result=$db->select("SELECT forum_id, forum_name, descr, total_posts, total_themes, DATE_FORMAT(last_post, '%d.%m.%Y %H:%m:%s') as last_post, last_user  FROM ?_forum_forums");
 foreach($result as $tmp)
 {
  $forums[]=array(
              'forum_id'=>$tmp['forum_id'],
              'forum_name'=>bbcode($tmp['forum_name']),
              'descr'=>bbcode_all($tmp['descr']),
              'total_posts'=>$tmp['total_posts'],
              'total_themes'=>$tmp['total_themes'],
              'last_post'=>$tmp['last_post'],
              'last_user'=>text_string($tmp['last_user']));
 }
 $smarty->assign('forums', $forums);

?>