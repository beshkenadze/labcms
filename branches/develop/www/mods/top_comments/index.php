<?
 $mod_template="top_comments.tpl";
if(access("read")) {
	$sql = "SELECT u.user_id, login, u.email as u_email, name, c.email as c_email, putdate, msg, comment_id, INET_NTOA(ip) as ip FROM ?_comments c LEFT JOIN ?_users u ON c.user_id=u.user_id  ORDER BY putdate DESC LIMIT ?d";
	$result=$db->select($sql, $config['top_comments']);
	if (count($result))
		{
			foreach($result as $comms)
			{
				if ($comms['user_id'])
				{
					$c_name=text_string($comms['login']);
					$c_email=text_string($comms['u_email']);
				}
				else
				{
					$c_name=text_string($comms['name']);
					$c_email=text_string($comms['c_email']);
				}

				$c_msg=bbcode_all($comms['msg']);
				$smarty->append('comments',array('name'=>$c_name, 'email'=>$c_email, 'putdate'=>$comms['putdate'], 'msg'=>$c_msg, 'id'=>$comms['comment_id'], 'ip'=>$comms['ip']));
			}
		}
}
?>