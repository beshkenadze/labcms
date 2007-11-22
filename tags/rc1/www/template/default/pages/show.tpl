<div>
{if $access_edit}
<a href="{$smarty.server.PHP_SELF}pages-edit.{$page_id}{$ext}">редактировать</a>

{/if}
{if $access_delete}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="{$smarty.server.PHP_SELF}pages-delete.{$page_id}{$ext}">удалить</a>
{/if}
</div>
<h1>{$page_title}</h1>
{$page_text}
