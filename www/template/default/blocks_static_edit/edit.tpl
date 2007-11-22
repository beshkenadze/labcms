<form action="{$smarty.server.PHP_SELF}{if $smarty.get.action}-{$smarty.get.action}{/if}{if $smarty.get.var1}.{$smarty.get.var1}{/if}{$ext}" method="post">
<p>Имя блока<br /><input type="text" name="name" value="{$name|default:$smarty.post.name|escape}"></p>
<p>Данные<br /><textarea name="data" cols="50" rows="10">{$data|default:$smarty.post.data|escape}</textarea></p>
<p><input type="submit" value="Сохранить"></p>
</form>
{if $errors}
<br />
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}