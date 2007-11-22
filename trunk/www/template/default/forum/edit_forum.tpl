<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var1}.{$smarty.get.var1}{/if}{$ext}" method="post">
<p>Название форума*<br /><input type="text" name="forum_name" value="{$forum_name|escape|default:$smarty.post.forum_name}" /></p>
<p>Описание<br />
<textarea rows="20" name="descr">{$descr|escape|default:$smarty.post.descr}</textarea></p>
<p>Закрытый<br /><input type="checkbox" name="closed" {if $smarty.post.closed || $closed}checked{/if}" /></p>
<p><input class="button" type="submit" value="Отправить" /></p>
</form>

{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}
