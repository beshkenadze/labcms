<div id="main">
{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
<ul>
{foreach from=$errors item=error_msg}
	<li>{$error_msg}</li>
{/foreach}
</ul>
{/if}

<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var1}.{$smarty.get.var1}{/if}{$ext}" method="post">
<input type="hidden" name="tree_id" value="{$tree_id|default:"`$smarty.post.tree_id`"|escape}">
<p>Название страницы*<br />
<input name="title" type="text" value="{$title|default:"`$smarty.post.title`"|escape}"></p>
<p>Родитель<br />
  <select name="parent_id">
   {html_options options=$parent_select selected=$parent_id_sel|default:$smarty.post.parent_id}
  </select>
</p>
<p>URL<br />
<input name="path" type="text" value="{$path|default:"`$smarty.post.path`"|escape}"></p>
<p><input type="submit" value='Сохранить'></p>
<!-- tinyMCE -->
{include file=WYSIWYG/editor.tpl field="page_content"}
<!-- /tinyMCE -->
<textarea name="page_content" rows="30" style="width:100%">{$page_content}</textarea>
</form>
</div>