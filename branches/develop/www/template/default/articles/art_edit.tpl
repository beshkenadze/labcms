{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}

<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var1}.{$smarty.get.var1}{/if}{$ext}" method="post">
<input type="hidden" name="tree_id" value="{$tree_id|default:"`$smarty.post.tree_id`"|escape}">
<p>Название статьи*<br />
<input name="art_name" value="{$art_name|default:"`$smarty.post.art_name`"|escape}"></p>
<p>Дата публикации*<br />
<input name="art_date" value="{$art_date|default:"`$smarty.post.art_date`"|escape}"></p>
<p>Заголовок окна*<br />
<input name="art_title" value="{$art_title|default:"`$smarty.post.art_title`"|escape}"></p>
<p>URL*<br />
<input name="art_path" value="{$art_path|default:"`$smarty.post.art_path`"|escape}"></p>
<p><input type=submit value='Сохранить'></p>
<!-- tinyMCE -->
{include file=WYSIWYG/editor.tpl field="art_content"}
<!-- /tinyMCE -->
<textarea name="art_content" rows="30" style="width:100%">
{$art_content}
</textarea>
</form>
