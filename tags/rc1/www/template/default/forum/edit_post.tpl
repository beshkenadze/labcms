{include file=forum/header.tpl}
{if $mode=="reply"}
<table class="forum_p">
<tr>
 <td colspan="2" class="subject">{$reply_info.subject}</td>
</tr>
<tr>
 <td valign="top" style="width:100px">
 {$reply_info.user_name}<br />
{if $reply_info.email}
 {mailto address=$reply_info.email text="email" encode="javascript"}<br />
{/if}
</td>
<td>
<div class="smalltext">{$reply_info.putdate}</div>
{$reply_info.msg}
</td>
</tr>
</table>
{/if}

<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var1}.{$smarty.get.var1}{/if}{$ext}" method="post">
{if ($mode == "edit" && $user_name)}
<p>Имя*<br /><input type="text" name="{$catcher}" value="{$user_name|escape}" readonly /></p>
{elseif $user_info.login}
<p>Имя*<br /><input type="text" name="{$catcher}" value="{$user_info.login|escape}" readonly /></p>
{else}
<input type="text" name="name" value="" class="catch" />
<p>Имя*<br /><input type="text" name="{$catcher}" value="{$user_name|escape|default:$smarty.post.name}" /></p>
<p>Email<br /><input type="text" name="email" value="{$email|escape|default:$smarty.post.email}" /></p>
{/if}
{if $edit_subj}<p>Тема*<br /><input class="wide" type="text" name="subj" value="{$subject|escape|default:$smarty.post.subject}"></p>
{if $mode=="edit" && access('edit') && $edit_subj}<p>Перенести в форум<br />{html_options options=$select_forum selected=$current_forum name=move_to_forum}</p>{/if}
{/if}
<p>Сообщение*<br />
<input  onclick="javascript:tag('[b]','[/b]','msg')" type="button" value="B" style="width:23px; font-weight:bold;" title="Жирный" />
<input  onclick="javascript:tag('[i]','[/i]','msg')" type="button" value="I" style="width:23px; font-style:italic;font-weight:bold" />
<input  onclick="javascript:tag('[u]','[/u]','msg')" type="button" value="U" style="width:23px; text-decoration: underline;font-weight:bold" />
<input  onclick="javascript:tag('[q]','[/q]','msg')" type="button" value="Q" style="width:23px; font-weight:bold;" />
<input  onclick="javascript:tag('[img]','[/img]','msg')" type="button" value="IMG" style="width:35px; font-weight:bold;" />
<input  onclick='javascript:tag("[url=\"","\"][/url]","msg")' type="button" value="URL" style="width:35px; font-weight:bold;" />
<br />
<textarea rows="20" name="msg" id="msg">{$msg|escape|default:$smarty.post.msg}</textarea></p>
<p><input class="button" type="submit" value="Отправить" /></p>
</form>

{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}
{include file=forum/footer.tpl}