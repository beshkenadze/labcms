{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}

<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var2}.entry/{$smarty.get.var2}{/if}{$ext}" method="post">
<p>Дата*<br />
<input type="text" name="blog_date" value="{$blog_date|default:"`$smarty.post.blog_date`"|escape}"></p>
<p>Заголовок<br />
<input type="text" name="blog_title" value="{$blog_title|default:"`$smarty.post.blog_title`"|escape}"></p>
<p><input type=submit value='Сохранить'></p>
<!-- tinyMCE -->
{include file=WYSIWYG/editor.tpl field="blog_text"}
<!-- /tinyMCE -->
<textarea name="blog_text" cols="50" rows="15">
{$blog_text}
</textarea>
</form>