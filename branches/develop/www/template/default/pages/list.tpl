<div id="main">
{if $access_add}<div><a href="{$smarty.server.PHP_SELF}-add{$ext}">Создать новую страницу</a></div>{/if}
<table>
{section name=l loop=$list}
<tr><td><a href="{$smarty.server.PHP_SELF}.{$list[l].page_id}{$ext}">{$list[l].page_title}</a></td><td>{if $list[l].path}<a href="{$list[l].path}">{$list[l].path}</a>{else}удалена{/if}</td>{if $access_edit}<td><a href="{$smarty.server.PHP_SELF}-edit.{$list[l].page_id}{$ext}">редактировать</a></td>{/if}{if $access_delete}<td><a href="{$smarty.server.PHP_SELF}-delete.{$list[l].page_id}{$ext}">удалить</a></td>{/if}
{sectionelse}
<tr><td>Пока не создано ни одной страницы</td></tr>
{/section}
</table>
</div>