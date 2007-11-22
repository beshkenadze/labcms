{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}
<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var1}.{$smarty.get.var1}/{/if}" method="post">
<p>Дата*<br />
<input type="text" name="news_date" value="{$news_date|default:"`$smarty.post.news_date`"|escape}"></p>
<p>Заголовок<br />
<input type="text" name="news_title" value="{$news_title|default:"`$smarty.post.news_title`"|escape}"></p>
<p><input type=submit value='Сохранить'></p>
<!-- tinyMCE -->
{include file=WYSIWYG/editor.tpl field="news_text"}
<!-- /tinyMCE -->
<textarea name="news_text" rows="30" style="width:100%">
{$news_text}
</textarea>
</form>